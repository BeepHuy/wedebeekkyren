var DB = require('./module_DBbase');
var check = require('./module_check.js');
//module_check.js
const path = require('path')
const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
var socks = require('socksv5'),
    Client = require('ssh2').Client;
const { Server } = require("socket.io");
const io = new Server(server);
var pathp = __dirname + '/chrome_profile';
var UserAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36"
const puppeteer = require('puppeteer-extra')
const StealthPlugin = require('puppeteer-extra-plugin-stealth')
puppeteer.use(StealthPlugin())
const { executablePath } = require('puppeteer')
var ssh_config = {};
var events = require('events');
events.EventEmitter.defaultMaxListeners = 0;
var eventEmitter = new events.EventEmitter();
const bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({ extended: true }));
var browser;
io.on('connection', (socket) => {
    var qr = `SELECT * FROM  cpalead_network_source`;
    DB.getData(qr)
        .then(async dt => {
            socket.emit('network_source', dt)
        }).catch(async err => {
            socket.emit('network_source', '')
        })
    eventEmitter.on('guidulieu', function (data) {
        // { 'url ': page.url(), index: index }
        //console.log(data)
        socket.emit('data_check', data)
    })
    console.log('a user connected');
});
app.get("/check_source", (req, res) => {
    if (browser) {
        try {
            browser.close()
        } catch (error) {

        }
    }
    res.sendFile(path.join(__dirname, "views/index.html"))
})
app.post("/check_source", async (req, res) => {
    if (browser) {
        try {
            browser.close()
        } catch (error) {

        }
    }
    //31.192.232.86|22|bestvpnssh-jjjh|gggh
    //5.161.124.156|22|root|duymuoinguyen
    var urls = req.body.url.replace(/\r\n/g, "\n").split('\n');
    var ssh = req.body.ssh;
    ssh = ssh.split('|');
    ssh_config = {
        host: ssh[0],
        port: ssh[1],
        username: ssh[2],
        password: ssh[3]
    };
    var dt = await open_browser(urls);
    //res.sendFile(path.join(__dirname, "views/index.html"))\
    res.send('1')
})
server.listen(3000, () => {
    console.log('listening on *:3000');
});
function base64_decode(s) {
    return decodeURIComponent(escape(atob(s)));
}
function base64_encode(s) {
    return Buffer.from(s).toString('base64')
}
//chưa làm bấm tắt thì tương đương disconnect

async function open_browser(urls) {
    //fs.rmSync(pathp, { recursive: true, force: true });
    //proxy = proxy.split('|');
    var proxy = "localhost:9999"
    browser = await puppeteer.launch(
        {
            headless: true,
            executablePath: executablePath(),
            args: ['--no-sandbox', '--disable-setuid-sandbox',
                '--user-data-dir=' + pathp,
                '--window-size=1080,1000',
                `--proxy-server=socks5://${proxy}`,
                '--lang=en-US'
            ]
        }
    );
    await Promise.all(urls.map(async (url, index) => {
        const page = await browser.newPage();
        await page.setUserAgent(UserAgent);

        await page.setRequestInterception(true);
        page.on('request', (req) => {
            if (req.resourceType() == 'font' || req.resourceType() == 'image') {
                req.abort();
            }
            else {
                req.continue();
            }
        });
        var redirects = [];
        //const client = await page.target().createCDPSession();
        //await client.send('Network.enable');
        // await client.on('Network.requestWillBeSent', (e) => {
        //     if (e.type !== "Document") {
        //         return;
        //     }
        //     console.log(index);
        //     console.log(e.documentURL);
        //     redirects.push(e.documentURL);
        // });
        await page.setDefaultNavigationTimeout(120000)
        try {
            await page.goto(url, { waitUntil: 'domcontentloaded' });
            // await page.waitForNavigation({ waitUntil: 'domcontentloaded' });//{ 'waitUntil': 'networkidle0' }
            await new Promise((resolve, reject) => setTimeout(resolve, 5000));
            eventEmitter.emit('guidulieu', { url: page.url(), index: index });


        } catch (error) {
            eventEmitter.emit('guidulieu', { url: error, index: index });
            //console.log('err ->' + error)
        }

        page.close();
    })).then((dt) => {

    }).catch((err) => {
        console.log('lỗi')
    })
    browser.close();

}


//fake ip


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
}).listen(9999, 'localhost', function () {
    console.log('SOCKSv5 proxy server started on port 9999');
}).useAuth(socks.auth.None());
function base64_encode(s) {
    return Buffer.from(s).toString('base64')
}
