var DB = require('./module_DBbase');
const puppeteer = require('puppeteer-extra')
const StealthPlugin = require('puppeteer-extra-plugin-stealth')
puppeteer.use(StealthPlugin())
const { executablePath } = require('puppeteer')
var socks = require('socksv5'),
    Client = require('ssh2').Client;
const fs = require('fs');
var pathp = __dirname + '/chrome_profile';
var UserAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36"
module.exports = async (ssh, url) => {
    return new Promise(async function (resolve, reject) {
        //do something

        var dt = await open_browser(url);
        resolve(dt);
        // if (cookie_id > 0) {
        //     var qr = ` SELECT * FROM  extension_acc WHERE account_id=${cookie_id}`;
        //     var dt = await DB.getData(qr).catch((err) => {
        //         reject(err);
        //     })
        //     if (dt.length > 0) {
        //         dt.forEach(async data => {
        //             try {
        //                 if (data.account_type == 1) {//shemrush
        //                     var cookie = await semrush_cookie(data.account_email, data.account_password, data.proxy_server);
        //                 } else if (data.account_type == 2) {
        //                     var cookie = await spamzilla_cookie(data.account_email, data.account_password, data.proxy_server);
        //                 } else if (data.account_type == 3) {
        //                     var cookie = await bigspy_cookie(data.account_email, data.account_password, data.proxy_server);
        //                 }
        //                 else if (data.account_type == 4) {
        //                     var cookie = await ahrefs_cookie(data.account_email, data.account_password, data.proxy_server);
        //                 }
        //                 else if (data.account_type == 5) {
        //                     var cookie = await pipiads_cookie(data.account_email, data.account_password, data.proxy_server);
        //                 }

        //             } catch (error) {
        //                 //console.log('error get coookie');
        //             }


        //             if (cookie) {
        //                 cookie = JSON.stringify(cookie);
        //                 cookie = base64_encode(cookie);
        //                 qrr = `UPDATE extension_acc SET account_cookie = '${cookie}' WHERE account_id='${data.account_id}'`;
        //                 DB.getData(qrr)
        //                     .then(() => {
        //                         resolve({ status: 1, mess: __dirname + '/2.jpg' })
        //                     })
        //                     .catch(() => {
        //                         resolve({ status: 0, mess: 'Update cookies error!' })
        //                     })
        //             } else {
        //                 resolve({ status: 0, mess: 'Empty cookies!' })
        //             }

        //         });

        //     } else {
        //         resolve({ status: 0, mess: 'Tài KHoản không tồn tại' })
        //     }
        // } else {
        //     resolve({ status: 0, mess: 'Lỗi Id tài khoản ' })
        // }
    });


    //res.sendFile(__dirname + '/views' + '/index.html');
};
async function open_browser(url) {
    fs.rmSync(pathp, { recursive: true, force: true });
    //proxy = proxy.split('|');
    var proxy = "localhost:9988"
    const browser = await puppeteer.launch(
        {
            headless: false,
            executablePath: executablePath(),
            args: ['--no-sandbox', '--disable-setuid-sandbox',
                '--user-data-dir=' + pathp,
                '--window-size=1080,1000',
                `--proxy-server=${proxy}`,
                '--lang=en-US'
            ]
        }
    );
    const page = await browser.newPage();
    await page.setUserAgent(UserAgent);
    // await page.authenticate({
    //     username: proxy[1],
    //     password: proxy[2],
    // });
    await page.setRequestInterception(true);
    page.on('request', (req) => {
        if (req.resourceType() == 'font' || req.resourceType() == 'image') {
            req.abort();
        }
        else {
            req.continue();
        }
    });

    await page.goto(url);
    await new Promise((resolve, reject) => setTimeout(resolve, 2000));
    try {
        await page.screenshot({
            fullPage: true,
            path: '2.jpg'
        });
    } catch (error) {

    }

    //browser.close();

}


//fake ip
var ssh_config = {
    host: '5.161.124.156',
    port: 22,
    username: 'root',
    password: 'duymuoinguyen'
};

socks.createServer(function (info, accept, deny) {
    // NOTE: you could just use one ssh2 client connection for all forwards, but
    // you could run into server-imposed limits if you have too many forwards open
    // at any given time
    var conn = new Client();
    conn.on('ready', function () {
        conn.forwardOut(info.srcAddr,
            info.srcPort,
            info.dstAddr,
            info.dstPort,
            function (err, stream) {
                if (err) {
                    conn.end();
                    return deny();
                }

                var clientSocket;
                if (clientSocket = accept(true)) {
                    stream.pipe(clientSocket).pipe(stream).on('close', function () {
                        conn.end();
                    });
                } else
                    conn.end();
            });
    }).on('error', function (err) {
        deny();
    }).connect(ssh_config);
}).listen(9988, 'localhost', function () {
    console.log('SOCKSv5 proxy server started on port 1080');
}).useAuth(socks.auth.None());
function base64_encode(s) {
    return Buffer.from(s).toString('base64')
}
