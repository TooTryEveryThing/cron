const puppeteer = require('puppeteer');
const path = require('path');

async function captureScreenshot() {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();

  await page.setViewport({ width: 1920, height: 1080 }); // 根据需要设置宽度和高度
  
  await page.goto('http://zovs.cn/'); // 替换成你的网站地址
  
 // 获取当前日期和时间
  const currentDate = new Date();
  const timezoneOffset = currentDate.getTimezoneOffset(); // 获取时区偏移量，单位为分钟
  const localDate = new Date(currentDate.getTime() - (timezoneOffset * 60000) + (8 * 3600000)); // 修正时区偏移量为 UTC+8
  
  // const formattedDate = currentDate.toISOString().slice(0, 10); // 格式化日期为 yyyy-MM-dd
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0');
  const day = String(currentDate.getDate()).padStart(2, '0');
  const hours = String(currentDate.getHours()).padStart(2, '0');
  const minutes = String(currentDate.getMinutes()).padStart(2, '0');
  const seconds = String(currentDate.getSeconds()).padStart(2, '0');
  
  // 生成截图文件路径和名称
  // const screenshotPath = path.join(__dirname, `${formattedDate}.png`);

  const screenshotPath = path.join(__dirname, `${year}-${month}-${day} ${hours}-${minutes}-${seconds}.png`);
  
  // 设置截图选项
  const screenshotOptions = {
    path: screenshotPath, // 保存截图的文件路径和名称
    fullPage: false, // 截取整个页面
    clip: { x: 0, y: 0, width: 1920, height: 1080 }
  };
  await page.screenshot(screenshotOptions);
  
  await browser.close();
}

captureScreenshot();




// //可以使用
// const puppeteer = require('puppeteer');
// const path = require('path');

// async function captureScreenshot() {
//   const browser = await puppeteer.launch();
//   const page = await browser.newPage();
//   await page.goto('https://beink.cn'); // 替换成你的网站地址
//     // 获取当前日期
//   const currentDate = new Date();
//   const formattedDate = currentDate.toISOString().slice(0, 10); // 格式化日期为 yyyy-MM-dd
  
//   // 生成截图文件路径和名称
//   const screenshotPath = path.join(__dirname, `${formattedDate}.png`);
  
//   await page.screenshot({ path: screenshotPath }); // 保存截图的文件路径和名称
//   await browser.close();
// }

// captureScreenshot();
