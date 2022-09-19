# Options in detail

## uniqueId
| name     | type   | required  | default value |
|----------|--------|-----------|---------------|
| uniqueId | string | no        | (empty)       |

Unique Id of the cropper widget. It will be created automatically if it is empty.

These elements will have unique Ids by appending it.

* buttonId          = #cropper-select-button-$uniqueId
* previewId         = #cropper-result-$uniqueId
* modalId           = #cropper-modal-$uniqueId
* imageId           = #cropper-image-$uniqueId
* inputChangeUrlId  = #cropper-url-change-input-$uniqueId
* cropButtonId      = #crop-button-$uniqueId
* inputId           = #cropper-input-$uniqueId

## imageUrl
| name     | type   | required | default value |
|----------|--------|----------|---------------|
| imageUrl | string | no       | (empty)       |

The url of the source image file to crop.

When you want to crop an existing image in `update` scenario, you can set this property.
Otherwise you can safely ignore it.

## cropperOptions
| name           | type  | required | default value |
|----------------|-------|----------|---------------|
| cropperOptions | array |          |               |

The cropper option array in `key => value` format. Some of them are mandatory.

### width and height
| name                     | type | required | default value |
|--------------------------|------|----------|---------------|
| cropperOptions['width']  | int  | yes      |               |
| cropperOptions['height'] | int  | yes      |               |

The dimensions of the image to be saved as the result of cropping. Both width and height are required.

### buttonCssClass
| name                             | type   | required | default value     |
|----------------------------------|--------|----------|-------------------|
| cropperOptions['buttonCssClass'] | string | no       | 'btn btn-primary' |

The css class of the buttons.

### preview
| name                      | type               | required | default value |
|---------------------------|--------------------|----------|---------------|
| cropperOptions['preview'] | false &#124; array | no       | false         |

The options for the preview image. The preview image won't be displayed if it is false.

| name                                | type              | required | default value |
|-------------------------------------|-------------------|----------|---------------|
| cropperOptions['preview']['width']  | int &#124; string | no       | 100           |
| cropperOptions['preview']['height'] | int &#124; string | no       | 100           |

The dimensions of the preview window in pixcels.

Alternatively you can set width and height using string instead of integer. (e.g. "100px", "100%" )

| name                             | type   | required | default value |
|----------------------------------|--------|----------|---------------|
| cropperOptions['preview']['url'] | string | no       | (empty)       |

The source of the initial image displayed in the preview window.

Like `imageUrl` option, you may want to set this property in `update` scenario.
Otherwise you can safely set it tu empty.

### useFontAwesome
| name                             | type | required | default value |
|----------------------------------|------|----------|---------------|
| cropperOptions['useFontAwesome'] | bool | no       | false         |

Whether to use `FontAwesome` icons or not. It is false by default, and unicode symbol characters will be used.

FontAwesome resources are not included in this extension.
In order to use FontAwesome icons, you have to set up your project to utilize it outside this extension.
See [Get Started with Font Awesome](https://fontawesome.com/start).


### icons
| name                                         | Unicode | FontAwesome                                             |
|----------------------------------------------|---------|---------------------------------------------------------|
| cropperOptions['icons']['browse']            | 🗁      | `<i class="fa-solid fa-folder-open"></i>`               |
| cropperOptions['icons']['ok']                | ✔       | `<i class="fa-solid fa-check"></i>`                     |
| cropperOptions['icons']['cancel']            | 🗙      | `<i class="fa-solid fa-xmark"></i>`                     |
| cropperOptions['icons']['zoom-in']           | 🔍+     | `<i class="fa-solid fa-magnifying-glass-plus"></i>`     |
| cropperOptions['icons']['zoom-out']          | 🔍-     | `<i class="fa-solid fa-magnifying-glass-minus"></i>`    |
| cropperOptions['icons']['rotate-left']       | ⭯       | `<i class="fa-solid fa-arrow-rotate-left"></i>`         |
| cropperOptions['icons']['rotate-right']      | ⭮       | `<i class="fa-solid fa-arrow-rotate-right"></i>`        |
| cropperOptions['icons']['flip-horizontal']   | 🡘      | `<i class="fa-solid fa-arrows-h"></i>`                  |
| cropperOptions['icons']['flip-vertical']     | 🡙      | `<i class="fa-solid fa-arrows-v"></i>`                  |
| cropperOptions['icons']['move-left']         | 🡐      | `<i class="fa-solid fa-arrow-left"></i>`                |
| cropperOptions['icons']['move-right']        | 🡒      | `<i class="fa-solid fa-arrow-right"></i>`               |
| cropperOptions['icons']['move-up']           | 🡑      | `<i class="fa-solid fa-arrow-up"></i>`                  |
| cropperOptions['icons']['move-down']         | 🡓      | `<i class="fa-solid fa-arrow-down"></i>`                |
| cropperOptions['icons']['cursor-cross-hair'] | 🞡      | `<i class="fa-solid fa-plus"></i>`                      |
| cropperOptions['icons']['cursor-move']       | ✥       | `<i class="fa-solid fa-arrows-up-down-left-right"></i>` |

This table shows the default values of the icon definitions. 
Depending on `cropperOpitons['useFontAwesome']`, different icons will be used.

You may override any one of them. It's possible to mix unicode icons with fontAwesome ones.

## jsOptions
| name      | type  | required | default value |
|-----------|-------|----------|---------------|
| jsOptions | array | no       | (empty)       |

The javascript options associated with the cropper widget.
Currently only `jsOptions['onClik']` is supported.

| name                 | type   | required | default value |
|----------------------|--------|----------|---------------|
| jsOptions['onClick'] | string | no       | (empty)       |

You may set a javascript that will be triggered when `OK` button is clicked.

## label
| name  | type                | required | default value |
|-------|---------------------|----------|---------------|
| label | string &#124; false | no       | (empty)       |

The label of the cropper widget. It defaults to the label of the model's attribute.

Optionally you can set your own text or hide it (by setting false).

## template
| name     | type    | required | default value       |
|----------|---------|----------|---------------------|
| template | string  | no       | '{preview}{button}' |

The template of the cropper widget. It recognizes '{preview}' and '{button}'.

## modalOptions
| name         | type  | required | default value |
|--------------|-------|----------|---------------|
| modalOptions | array | no       | (empty)       |

The options for the modal dialog.

### title
| name                  | type   | required | default value |
|-----------------------|--------|----------|---------------|
| modalOptions['title'] | string | no       | (empty)       |

The title of the modal. It will be set automatically when it is not specified.

### modalClass
| name                       | type   | required | default value |
|----------------------------|--------|----------|---------------|
| modalOptions['modalClass'] | string | no       | 'modal-lg'    |

The CSS class of the modal. You may set 'modal-md', 'modal-lg' or 'modal-xl'.
The default value is 'modal-lg', and it is also the recommended value.

### image canvas and control panel
| name                        | type   | required | default value |
|-----------------------------|--------|----------|---------------|
| modalOptions['canvasClass'] | string | no       | 'col-8'       |
| modalOptions['panelClass']  | string | no       | 'col-4'       |

The CSS classes of the image canvas and the control panel.

They are laid out horizontally by default, with the relative widths of 8 to 4.
You can set a different width ratio like 'col-9' and 'col-3' or 'col-7' and 'col-5'.
The widths should add up to 12.

If you want a vertical layout, set 'col-12' to both of them. 

### information display
| name                          | type   | required | default value |
|-------------------------------|--------|----------|---------------|
| modalOptions['sizeDisp']      | bool   | no       | true          |
| modalOptions['sizeDispClass'] | string | no       | 'col-12'      |
| modalOptions['posDisp']       | bool   | no       | true          |
| modalOptions['posDispClass']  | string | no       | 'col-8'       |

The options that control the information display.

The default values are optimized for a horizontally laid out large modal('modal-lg).
You may want to customize them as you like.

### control buttons
| name                          | type   | required | default value |
|-------------------------------|--------|----------|---------------|
| modalOptions['zoomEnabled']   | bool   | no       | true          |
| modalOptions['rotateEnabled'] | bool   | no       | true          |
| modalOptions['flipEnabled']   | bool   | no       | true          |
| modalOptions['scrollEnabled'] | bool   | no       | true          |

The options that control the control button display.

### help message
| name                     | type   | required | default value |
|--------------------------|--------|----------|---------------|
| modalOptions['showHelp'] | bool   | no       | true          |

Whether to display the help message.
