# yii2-cropper-bs5
Yii2 Image Cropper Input Widget for bootstrap 5

Features
--------
This is a wrapper of <a href="https://fengyuanchen.github.io/cropperjs/" target="_blank">fengyuanchen/Cropper.js</a>.
It provides the following feature:

+ Crop
+ Image Rotate
+ Image Flip
+ Image Zoom
+ Coordinates
+ Image Sizes Info
+ Base64 Data
+ Set Image.Url Directly 
+ Set Image.Src With Javascript

Difference from bilginnet/yii2-cropper
--------------------------------------

This is a fork of [bilginnet/yii2-cropper](https://github.com/bilginnet/yii2-cropper),
but it has some important difference:

+ Works with bootstrap 5
+ Improved UI design of the modal
+ Supports the latest version of Cropper.js through composer
+ Backward incompatibility
  + Doesn't work with bootstrap 3
  + Some incompatibility in the options

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist softark/yii2-cropper-bs5 "dev-master"
```

or add

```
"softark/yii2-cropper-bs5": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

### 1) Add aliases for image directory

Add aliases for the directory to store the images in your config file.

```php
       $baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());

       Yii::setAlias('@imagesUrl', $baseUrl . '/images/');
       Yii::setAlias('@imagesPath', realpath(dirname(__FILE__) . '/../images/'));
       // image file will be stored in //root/images folder
       
       return [
           ....
       ]
```

### 2) Extend model to handle image data from cropper

Add a virtual attribute for the image data from the cropper widget in your model.

```php
    public $_image

    public function rules()
    {
        return [
            ['_image', 'safe'],
        ];
    }
```

And write a function to save the image data from the cropper widget.

```php
    public function beforeSave($insert)
    {
        if (is_string($this->_image) && strstr($this->_image, 'data:image')) {

            // creating image file as png, for example
            // cropper sends image data in a base64 encoded string
            $data = $this->_image;
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            $fileName = time() . '-' . rand(100000, 999999) . '.png';
            file_put_contents(Yii::getAlias('@imagesPath') . '/' . $fileName, $data);

            // deleting old image if any
            // $this->filename is the real attribute for the filename
            // customize your code for your attribute
            if (!$this->isNewRecord && !empty($this->filename)) {
                @unlink(Yii::getAlias('@imagesPath') . '/' . $this->filename);
            }
            
            // set new filename
            $this->filename = $fileName;
        }

        return parent::beforeSave($insert);
    }
```

### 3) Place cropper in _form file

The following is a typical code that appears in _form file:

```php
echo $form->field($model, '_image')->widget(\softark\cropper\Cropper::class, [

    // Unique ID of the cropper. Will be set automatically if not set.
    'uniqueId' => 'image_cropper',

    // The url of the initial image.
    // You can set the current image url for update scenario, and
    // set null for create scenario.
    // Defaults to null.
    'imageUrl' => ($model->isNewRecord) ? null : Yii::getAlias('@imagesUrl') . $model->filename,
    
    // Cropper options
    'cropperOptions' => [
        // The dimensions of the image to be cropped and saved.
        // You have to specify both width and height.
        'width' => 1200,
        'height' => 800,

        // Preview window options
        'preview' => [
            // The dimensions of the preview image must be specified.
            'width' => 600, // you can set as string '100%'
            'height' => 400, // you can set as string '100px'
            // The url of the initial image for the preview.
            'url' => (!empty($model->filename)) ? Yii::getAlias('@imagesUrl' . '/' . $model->filename) : null,
        ],

        // Whether to use FontAwesome icons
        'useFontAwesome' => true, // default = false : use Unicode Chars
    ],
    
    // Modal options
    'modalOptions' => [
        // Specify the size of the modal.
        // 'modal-md', 'modal-lg', or 'modal-xl'
        // Default and recommended value is 'modal-lg'
        'modalClass' => 'modal-lg',
    ],
 ]);
```

While much more options are supported for the widget,
usually you can safely ignore them to accept the default values.

### 4) Options in detail

YET TO BE DONE:

