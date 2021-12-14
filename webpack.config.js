const path = require('path'),
  webpack = require('webpack'),
  factory = require('./env/webpack.factory'),
  { CleanWebpackPlugin } = require('clean-webpack-plugin'),
  CopyWebpackPlugin = require('copy-webpack-plugin'),
  MiniCssExtractPlugin = require('mini-css-extract-plugin');

const { mode, entries, HtmlWebpackPlugins } = factory({
  pagesSrc: './src/Pages/',
});

console.log(`MODE: ${mode}\n`);

const config = {
  entry: entries, //entry points of project
  output: {

    filename: (pathData, assetInfo) => {
      //console.log('path data:', pathData);
      
      //console.log('asset info:', assetInfo);
      if (mode == 'development') {
        return '[name]/[name].bundle.js';
      } else {
        return '[name]/[name].[fullhash].js';
      }
    },
    path: path.resolve(__dirname, 'dist'), //target folder
  },
  plugins: [
    //new CleanWebpackPlugin({
    //  cleanOnceBeforeBuildPatterns: ['!./dist/**/index.php', './dist/**/*'], //dist folder clean up
    //}),
    ...HtmlWebpackPlugins,
    new CopyWebpackPlugin({
      patterns: [
        //{ from: 'src/Assets', to: '__assets' }, // because assets are loaded into __assets and such copy just rewrite changes by old files
        { from: 'php', to: '__php' },
        { from: 'src/Root', to: './' },
      ],
    }),
    new MiniCssExtractPlugin({ //scss compilation //./dist/index.css
      filename: ({ name }) => {
        if (mode == 'development') {
          return '[name]/[name].bundle.css';
        } else {
          return '[name]/[name].[fullhash].css';
        }
      },
    }),
    new webpack.ProvidePlugin({ //connecting jquery
      $: 'jquery',
      jQuery: 'jquery',
    }),
  ],
  module: {
    rules: [
      {
        test: /\.css$/, //prosessing of sass
        use: [
          'style-loader', //put css text as style tags on page, css won't be applied without it
          {
            loader: MiniCssExtractPlugin.loader, // store css to files in ./dist
            options: {
              //  // only enable hot reloading in development
              //  hmr: mode === 'development',
              //  // if hmr does not work, this is a forceful method.
              //  reloadAll: true,
              esModule: false, // fix warnings
            },
          },
          {
            loader: 'css-loader', //CSS to CommonJS, make possible require and import css files in js files
            options: {
              //url: false, //don't resolve url links in css files
            }
          },
          'postcss-loader', //added to use autoprefixer
        ],
      },
      {
        test: /\.s[ac]ss$/, //prosessing of sass
        use: [
          'style-loader', //put css text as style tags on page, css won't be applied without it
          {
            loader: MiniCssExtractPlugin.loader, // store css to files in ./dist
            options: {
              //  // only enable hot reloading in development
              //  hmr: mode === 'development',
              //  // if hmr does not work, this is a forceful method.
              //  reloadAll: true,
              esModule: false, // fix warnings
            },
          },
          {
            loader: 'css-loader', //CSS to CommonJS, make possible require and import css files in js files
            options: {
              //url: false, //don't resolve url links in css files
            }
          },
          'postcss-loader', //added to use autoprefixer
          'sass-loader', //complie SASS to CSS
        ]
      },
      {
        test: /\.pug$/, //processing pug
        use: {
          loader: 'pug-loader',
          options: {
            filters: {
              php(text, options) {
                return `<?php\n${text}?>`;
              }
            }
          }
        } //HtmlWebpackPlugin use this rule to process .pug files
      },
      {
        test: /\.(png|jpe?g|gif|ttf|svg)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[path][name].[ext]',
              context: path.resolve(__dirname, 'src/Attach'),
              outputPath: '__attach',
              //publicPath: (mode == 'development' ? './../../../Attach/' : '../Attach/'),
              publicPath: '../__attach/',
              useRelativePaths: true,
            },
          },
        ],
      },
    ]
  }
};

const development = {
  devtool: 'inline-source-map', //js debugger
  devServer: {
    contentBase: './dist', //localhost root folder
    open: true, //open in this browser
    host: '0.0.0.0',
  },
  watch: true,
};

const production = {
};

if (mode == 'development') {
  factory.objectMerge(config, development);
  config.module.rules.find(r => (r.test + '') == (/\.pug$/ + '')).use.options.pretty = true;
}
else { // production
  factory.objectMerge(config, production);
  config.module.rules.push({
    test: /\.m?js$/,
    loader: 'babel-loader',
  });
  config.module.rules.find(r => (r.test + '') == (/\.pug$/ + '')).use.options.pretty = false;
  config.plugins.push(new CleanWebpackPlugin({
    cleanOnceBeforeBuildPatterns: ['./**/*'], //dist folder clean up
  }));
}

factory.exclude(config, ['node_modules', 'dist']);

//console.log(config);

module.exports = config; 