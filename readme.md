# MyImages for PyroCMS

MyImages is a PyroCMS module (plugin) to display images in layout files. It can display image data, image tag and image tag inside an anchor tag. Also can display all images taken from the folder.

- version - 1.2.2
- Author  - Tanel Tammik - keevitaja@gmail.com
- Support - [PyroCMS forum](https://forum.pyrocms.com/discussion/24748/myimages-module-to-display-images-inside-layout-files)

## Install

Just copy module to your modules folder and install it. Backend in admin section is not available.

## Plugin

All methods in library Myimages.php can be called from plugin, except folder_array().

### `{{ myimages:url_thumb }}`

Returns url of the thumb image.

example:

	{{ myimages:url_thumb id="45e7c41ad7dd006" width="200" height="150" mode="fit" }}

output:

	http://pyro.localhost/files/thumb/45e7c41ad7dd006/200/150/fit/test_image.jpg

##### params

- `id` - image id (required)
- `width` - image width (default **auto**)
- `height` - image height (defaults **auto**)
- `mode` - image resizing mode (default **fit**), please refer to [pyrocms docs](http://docs.pyrocms.com/2.2/manual/plugins/files)

### `{{ myimages:url_large }}`

Returns url of the large image.

example:

	{{ myimages:url_large id="45e7c41ad7dd006" }}

output:

	http://pyro.localhost/files/large/45e7c41ad7dd006/test_image.jpg 

##### params

- `id` - image id (required)

### `{{ myimages:image_data }}`

Returns image information, including urls.

example:

	{{ myimages:image_data id="45e7c41ad7dd006" width="200" }}
		id: {{ id }} <br>
		folder_id: {{ folder_id }} <br>
		name: {{ name }} <br>
		title: {{ title }} <br>
		mimetype: {{ mimetype }} <br>
		orig width: {{ width }} <br>
		orig height: {{ height }} <br>
		alt: {{ alt }} <br>
		thumb url: {{ url_thumb }} <br>
		large url: {{ url_large }} <br>
	{{ /myimages:image_data }}

output:

	id: 45e7c41ad7dd006 <br>
	folder_id: 1 <br>
	name: test_image.jpg <br>
	title: text in anchor title attribute <br>
	mimetype: image/jpeg <br>
	orig width: 400 <br>
	orig height: 600 <br>
	alt: text in image alt attribute <br>
	thumb url: http://pyro.localhost/files/thumb/45e7c41ad7dd006/200/auto/fit/test_image.jpg <br>
	large url: http://pyro.localhost/files/large/45e7c41ad7dd006/test_image.jpg <br>

##### params

- `id` - image id (required)
- `width` - image width (default **auto**)
- `height` - image height (default **auto**)
- `mode` - image resizing mode (default **fit**), please refer to [pyrocms docs](http://docs.pyrocms.com/2.2/manual/plugins/files)

### `{{ myimages:image }}`

Returns image tag.

If both width and height are not specified, url will point to large image.

example:

	{{ myimages:image id="45e7c41ad7dd006" width="200" class="my-class" }}

output:

	<img class="my-class" src="http://pyro.localhost/files/thumb/45e7c41ad7dd006/200/auto/fit/test_image.jpg" alt="text in image alt attribute">

##### params

- `id` - image id (required)
- `class` - image class (default none)
- `width` - image width (default **auto**)
- `height` - image height (default **auto**)
- `mode` - image resizing mode (default **fit**), please refer to [pyrocms docs](http://docs.pyrocms.com/2.2/manual/plugins/files)

### `{{ myimages:anchor }}`

Returns anchor tag containing image tag

example:

	{{ myimages:anchor id="8a11326f71e590e" class="my-image" params="test|param,key|value" width="200" wrap="<span>%s</span>" }}

output:

	<a href="http://pyro.localhost/files/large/8a11326f71e590e/flower.jpg" title="flower title" class="my-image" test="param" key="value">
		<span><img src="http://pyro.localhost/files/thumb/8a11326f71e590e/200/auto/fit/flower.jpg" alt="flower alt"></span>
	</a>

##### params

- `id` - image id (required)
- `class` - anchor class (default none)
- `width` - image width (default **auto**)
- `height` - image height (default **auto**)
- `mode` - image resizing mode (default **fit**), please refer to [pyrocms docs](http://docs.pyrocms.com/2.2/manual/plugins/files)
- `wrap` - wrapper for image tag (default none)
- `params` - extra parameters for anchor tag, some lightboxes require it (default none)

### `{{ myimages:folder_images }}`

Returns list containing image id-s inside a folder.

Folder can be specified with id, slug or a name. One of them is required.

example:

	{{ myimages:folder_images id="1" }}
		image id: {{ id }} <br>
	{{ /myimages:folder_images }}

output:

	image id: 8a11326f71e590e
	image id: 45e7c41ad7dd006
	image id: e9906155610da81

##### params

- `id` - folder id
- `name` - folder name
- `slug` - folder slug

### `{{ myimages:images_data }}`

Returns list containing images data from specified folder.

example:

	{{ myimages:images_data id="1" }}
		{{ name }} <br>
	{{ /myimages:images_data }}
	
##### params

For folder lookup params see `{{ myimages:folder_images }}`

For full list of tags and other params see `{{ myimages:image_data }}`

### `{{ myimages:images }}`

Returns list containing image tags from specified folder.

example:

	{{ myimages:images id="1" width="200" }}
		{{ image }}
	{{ /myimages:images }}

##### params

For folder lookup params see `{{ myimages:folder_images }}`

For full list of params see `{{ myimages:image }}`

### `{{ myimages:anchors }}`

Returns list containing anchor tags from specified folder.

example:

	{{ myimages:anchors id="1" width="200" }}
		{{ anchor }}
	{{ /myimages:anchors }}

##### params

For folder lookup params see `{{ myimages:folder_images }}`

For full list of params see `{{ myimages:anchor }}`

## Stupid example

It would wiser to use `myimages:images_data`, but it sure is possible to go this way as well.

	{{ myimages:folder_images name="page_images" }}
		{{ myimages:image_data id="{{ id }}" }}
			{{ name }}<br>
			{{ myimages:anchor id="{{ id }}" width="200" }}<br>
			{{ alt }}
			<hr>
		{{ /myimages:image_data }}
	{{ /myimages:folder_images }}