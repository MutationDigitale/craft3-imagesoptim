# Images optimization plugin for Craft CMS

Compress images with image-optimizer (https://github.com/spatie/image-optimizer). Those following dependencies must be installed on the server:
                
- `sudo apt-get install jpegoptim`
- `sudo apt-get install optipng`
- `sudo apt-get install pngquant`
- `sudo npm install -g svgo`
- `sudo apt-get install gifsicle`

After, you can do that in twig (format in jpg in case the client uploads png images for photos):

```
<img src="{{ asset.getUrl({mode: 'crop', width: 100, height: 100, format: 'jpg') }}" >
```
