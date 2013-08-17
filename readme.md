# MyImages for PyroCMS

MyImages is a PyroCMS module (plugin) to display images in layout files. It can display image data, image tag and image tag inside an anchor tag. Also can display all images taken from the folder.

- version - 1.0.0
- Author  - Tanel Tammik - keevitaja@gmail.com

## Install

Just copy module to your modules folder and install it. Backend in admin section is not available.

## Plugin

All methods in library Myimages.php can be called from plugin.

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
- `height` - image height (defaults **auto**)
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
- `class` - image class (default **image**)
- `width` - image width (default **auto**)
- `height` - image height (defaults **auto**)
- `mode` - image resizing mode (default **fit**), please refer to [pyrocms docs](http://docs.pyrocms.com/2.2/manual/plugins/files)