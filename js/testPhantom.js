var page = require('webpage').create();
 
page.open('http://www.siamhtml.com', function() {
    page.render('siamhtml2.png'); // เซฟหน้าเว็บเป็นไฟล์ siamhtml.png
    phantom.exit(); // สั่งให้ phantomJS เลิกทำงาน
});