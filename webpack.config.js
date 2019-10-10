/**
 * Assets Config file
 */
const fs = require('fs');
const path = require('path');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const HtmlReplaceWebpackPlugin = require('html-replace-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageMinPlugin = require('imagemin-webpack-plugin').default;

const htmlPage = fs.readdirSync('./app').filter(f => /\.twig/g.test(f))

const config = {
  entry: {
    app: './app/js/app.js',
  },
  output: {
    filename: 'js/[name].js',
    path: path.resolve(__dirname, 'cms/admin/themes/gentellela/assets'),
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: ['style-loader', MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader', 'sass-loader'],
      },
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        loader: 'babel-loader',
      },
      {
        test: /\.(png|gif|jpg|jpeg)$/,
        use: [
          {
            loader: 'url-loader',
            options: { name: 'images/_design/[name].[ext]', publicPath: '../', limit: 0 },
          },
        ],
      },
      {
        test: /\.(eot|svg|ttf|woff|woff2)$/,
        use: [
          {
            loader: 'url-loader',
            options: { name: 'fonts/[name].[ext]', publicPath: '../', limit: 0 },
          },
        ],
      },
      {
        test: /\.twig$/,
        loader: 'twig-loader',
      },
    ],
  },
  optimization: {
    minimizer: [
      new TerserPlugin({
        parallel: true,
      }),
      new OptimizeCssAssetsPlugin({}),
    ],
  },
  externals: {
    jquery: 'jQuery',
  },
  plugins: [
    new BrowserSyncPlugin({
      proxy: 'http://yii2cms.man',
      // files: [
      //   'cms/**/*.php',
      // ],
      open: 'external',
      ghostMode: {
        clicks: false,
        location: false,
        forms: false,
        scroll: false,
      },
      injectChanges: true,
      logFileChanges: true,
      logLevel: 'debug',
      logPrefix: 'wepback',
      notify: true,
      reloadDelay: 100,
      // server: {
      //   baseDir: ['cms/admin/themes/gentellela'],
      //   directory: true,
      // },
    }),
    new MiniCssExtractPlugin({
      filename: 'css/[name].css',
    }),
    new ImageMinPlugin({ test: /\.(jpg|jpeg|png|gif|svg)$/i }),
    new CleanWebpackPlugin({
      /**
       * Some plugins used do not correctly save to webpack's asset list.
       * Disable automatic asset cleaning until resolved
       */
      cleanStaleWebpackAssets: false,
      // Alternative:
      // cleanAfterEveryBuildPatterns: [
      // copy-webpackPlugin:
      //   '!images/content/**/*',
      // url-loader fonts:
      //   '!**/*.+(eot|svg|ttf|woff|woff2)',
      // url-loader images:
      //   '!**/*.+(jpg|jpeg|png|gif|svg)',
      // ],
      verbose: true,
    }),
    new CopyWebpackPlugin([
      {
        from: path.resolve(__dirname, 'app', 'images'),
        to: path.resolve(__dirname, 'cms/admin/themes/gentellela', 'assets', 'images'),
        ignore: ['favicon.png'],
        toType: 'dir',
      },
      {
        from: path.resolve(__dirname, 'app', 'images', 'favicon.png'),
        to: path.resolve(__dirname, 'cms/admin/themes/gentellela', 'favicon.png'),
      },
    ]),
  ].concat(htmlPage.map(html => new HtmlWebpackPlugin({
    inject: true,
    hash: true,
    filename: `../${html.replace('.twig', '.html')}`,
    template: path.resolve(__dirname, 'app', html),
    favicon: path.resolve(__dirname, 'app', 'images', 'favicon.png'),
  }))).concat([
    new HtmlReplaceWebpackPlugin([
      {
        pattern: '"images/',
        replacement: '"assets/images/',
      },
    ]),
  ]),
};

module.exports = config;
