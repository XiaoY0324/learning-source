import { Logger } from "log4js";
import { Context } from "koa";
const errorHandler = {
  error(app) {
    interface KOAContext extends Context {
      // typeof logger;
      logger: Logger;
    }
    app.use(async (ctx: KOAContext, next: () => Promise<any>) => {
      // await next().catch(error => {
      try {
        await next();
      } catch (error) {
        // error logs pm2 logs
        ctx.logger.error(error);
        console.log(error);
        ctx.status = error.status || 500;
        ctx.body = "请求出错";
      }
    });
    app.use(async (ctx: KOAContext, next: () => Promise<any>) => {
      await next();
      if (404 !== ctx.status) return;
      ctx.status = 404;
      ctx.body =
        '<script type="text/javascript" src="//qzonestyle.gtimg.cn/qzone/hybrid/app/404/search_children.js" charset="utf-8" homePageUrl="http://yoursite.com/yourPage.html" homePageName="回到我的主页"></script>';
    });
  }
};
export default errorHandler;
