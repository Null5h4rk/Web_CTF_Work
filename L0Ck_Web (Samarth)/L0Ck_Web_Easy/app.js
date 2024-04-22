const express = require('express');
const app = express();
const bodyParser = require('body-parser');
const path = require('path');

const config = {
    buildNumber: "v20190816",
    debug: false,
    modelName: "Valencia",
    correctPin: "1928",
    secretText: "flag{V13w_r0b0t5.txt_c4n_b3_u53ful!!!}",
};

app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

app.get('/check-pin', (req, res) => {
    const pin = req.query.pin;

    if (pin === config.correctPin) {
        res.json({ success: true, secretText: config.secretText });
    } else {
        res.json({ success: false });
    }
});

app.listen(3000, () => {
    console.log('Server listening on port 3000');
});
