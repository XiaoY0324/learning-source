describe("测试基本函数的API", function () {
    // 钩子函数 beforEach befor 等..
    it("+1函数的应用", function () {
        expect(window.add(1)).toBe(1);
        expect(window.add(2)).toBe(3);
    })
});