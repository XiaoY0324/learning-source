const { join } = require('path');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin'); // 友好的错误提示
const WebpackBuildNotifierPlugin = require('webpack-build-notifier'); // webpack 弹窗提示
const setTitle = require('node-bash-title'); // 设置小黑板窗口title
const setIterm2Badge = require('set-iterm2-badge'); // 小黑板水印

setTitle('🍊开发环境配置');
setIterm2Badge('8000');

module.exports = {
    devServer: {
        contentBase: join(__dirname, 'dist'),
        hot: true,
        historyApiFallback: true // 解决假路由刷新的问题
    },
    plugins: [
        new WebpackBuildNotifierPlugin({
            title: "My Project Webpack Build",
            logo: join(__dirname, '../dogs.png'),
            suppressSuccess: true
        }),
        new FriendlyErrorsWebpackPlugin({
            compilationSuccessInfo: { // 启动成功
                messages: ['You application is running here http://localhost:8000'],
                notes: ['编译成功啦~']
            }
        })
    ]
}