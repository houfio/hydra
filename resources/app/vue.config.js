module.exports = {
  outputDir: '../../public/assets',
  publicPath: process.env.NODE_ENV === 'production' ? '/assets' : '/',
  indexPath: '../../resources/views/app.blade.php'
};
