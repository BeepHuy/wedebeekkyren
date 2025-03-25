var mysql = require("mysql");

var pool = mysql.createPool({
    connectionLimit: 100,
    host: 'localhost',
    user: 'root',
    password: 'duymuoinguyen',
    database: 'affise'
});
var DB = (function () {

    function _getData(query) {
        return new Promise((resolve, reject) => {
            pool.getConnection(function (err, connection) {

                if (err) {
                    connection.release();
                    reject(err);
                    //throw err;
                }

                connection.query(query, null, function (err, rows) {
                    connection.release();
                    if (!err) {
                        resolve(rows);
                    }
                    else {
                        reject(err);
                    }

                });

                connection.on('error', function (err) {
                    connection.release();
                    console.log(err);
                    reject(err);
                    //throw err;
                });
            });

        })
    }

    return {
        getData: _getData
    };

})();

module.exports = DB;