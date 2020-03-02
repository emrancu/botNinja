const buildConfig = [
    {
        source: 'resources/js/app.js',
        outputDir: 'assets',  // directory name of targeted output
        outputFileName: 'app'  // can be with .js extension
    }
];


/*
* no need to change here
* create configuration for webpack
*/
const path = require('path');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
let compile = {
    mode: 'development',
    devServer: {
        contentBase: path.join(__dirname, 'assets'),
        contentBasePublicPath: 'app'
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: "vue-loader"
            },
            {
                test: /\.(scss|css)$/,
                use: ["vue-style-loader", "css-loader", "sass-loader"]
            },
            {
                test: /\.js$/,
                loader: "babel-loader",
                exclude: /node_modules/
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin()
    ]
};


let webpackConfig = [];

buildConfig.forEach(item => {
    let fileName = item.outputFileName.split(".")[0];
    let configEntry = {};
    configEntry[fileName] = './' + item.source;

    compile['entry'] = configEntry;
    compile['output'] = {
        "filename": '[name].js',
        "path": __dirname + '/' + item.outputDir,
        publicPath: '/assets/'
    };
    webpackConfig.push(compile)
});

module.exports = webpackConfig;


