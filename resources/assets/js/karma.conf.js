module.exports = function(config) {
    config.set({

        browsers: ['PhantomJS'],

        files: [
            '../../../public/js/jquery.js',
            './node_modules/phantomjs-polyfill/bind-polyfill.js',
            { pattern: 'test-context.js'}
        ],

        frameworks: ['jasmine-jquery', 'jasmine'],

        preprocessors: {
            'test-context.js': ['webpack']
        },

        webpackMiddleware: {
                    // webpack-dev-middleware configuration
                    // i.e.
                    noInfo: true,
                    // and use stats to turn off verbose output
                    stats: {
                        // options i.e. 
                        chunks: false
                    }
                },
        webpack: {
            module: {
                loaders: [
                    { test: /\.js/, exclude: /node_modules/, loader: 'babel-loader' }
                ]
            },
            watch: true
        }
    });
};