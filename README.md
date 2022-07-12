
<div id="top"></div>

<div align="center">

<img src="https://svg-rewriter.sachinraja.workers.dev/?url=https%3A%2F%2Fcdn.jsdelivr.net%2Fnpm%2F%40mdi%2Fsvg%406.7.96%2Fsvg%2Ffile-tree.svg&fill=%23374151&width=200px&height=200px" style="width:200px;"/>

<h3 align="center">Shortcode : Sidebar Menu</h3>

<p align="center">
    Creates a wordpress sidebar menu tree that is fully collapsible and heirarchical. 
</p>    
</div>

##  1. <a name='TableofContents'></a>Table of Contents


* 1. [Table of Contents](#TableofContents)
* 2. [About The Project](#AboutTheProject)
	* 2.1. [Built With](#BuiltWith)
	* 2.2. [Installation](#Installation)
* 3. [Usage](#Usage)
	* 3.1. [General.](#General.)
	* 3.2. [Structure.](#Structure.)
		* 3.2.1. [Rawcode.](#Rawcode.)
		* 3.2.2. [Menu.](#Menu.)
	* 3.3. [Taxonomy.](#Taxonomy.)
	* 3.4. [Wrapper.](#Wrapper.)
	* 3.5. [Code.](#Code.)
		* 3.5.1. [Top-level `<ul>`](#Top-levelul)
		* 3.5.2. [Top Level `<\ul>`](#TopLevelul)
		* 3.5.3. [`<ul>`](#ul)
		* 3.5.4. [`</ul>`](#ul-1)
		* 3.5.5. [`<li>`](#li)
		* 3.5.6. [`</li>`](#li-1)
		* 3.5.7. [`<a>`](#a)
		* 3.5.8. [`<\a>`](#a-1)
		* 3.5.9. [Count number `(66)`](#Countnumber66)
	* 3.6. [Style.](#Style.)
	* 3.7. [Shortcode.](#Shortcode.)
* 4. [Troubleshooting](#Troubleshooting)
* 5. [Contributing](#Contributing)
* 6. [License](#License)
* 7. [Contact](#Contact)
* 8. [Changelog](#Changelog)



##  2. <a name='AboutTheProject'></a>About The Project

Creates a wordpress sidebar menu tree that is fully collapsible and heirarchical. 

You can assign a Taxonomy to the sidebar and it will generate the full structure.

<p align="right">(<a href="#top">back to top</a>)</p>



###  2.1. <a name='BuiltWith'></a>Built With

This project was built with the following frameworks, technologies and software.

* [ACF Pro](https://advancedcustomfields.com/)
* [PHP](https://php.net/)
* [Wordpress](https://wordpress.org/)
* [Composer](https://getcomposer.org/)
* [Tailwind](https://tailwindcss.com/)

<p align="right">(<a href="#top">back to top</a>)</p>




###  2.2. <a name='Installation'></a>Installation

These are the steps to get up and running with this plugin.

1. Clone the repo into your wordpress plugin folder
    ```sh
    git clone https://github.com/IORoot/wp-plugin__shortcode--sidebar-menu ./wp-content/plugins/shortcode-sidebar-tree
    ```
1. Composer.
    ```sh
    cd ./wp-content/plugins/shortcode-sidebar-tree
    composer install
    ```

<p align="right">(<a href="#top">back to top</a>)</p>



##  3. <a name='Usage'></a>Usage

The Sidebar Creator is accessible from the admin side menu.

It has five tabs with multiple sub-tabs.

###  3.1. <a name='General.'></a>General.

- Enabled. Allow this to be rendered or not.
- Sidebar Title. Instance name of each particular sidebar.
- Shortcode Slug. No spaces, only use underscores or hypens. Name of shortcode to be registered. This will be used in the shortcode to reference this menu instance.

![https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/general.png?raw=true](https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/general.png?raw=true)

###  3.2. <a name='Structure.'></a>Structure.

The structure tab allows you to 'build' the menu items to be included.

- Structure (row). Add multiple rows of different content.
    - Rawcode. Add raw HTML.
    - Menu. Add the items from a registered wordpress menu.
    - Taxonomy. Create a list of items linked to a taxonomy.

####  3.2.1. <a name='Rawcode.'></a>Rawcode.

The rawcode row allows you to add any HTML directly into the menu.

####  3.2.2. <a name='Menu.'></a>Menu.

- Menu. Select a registered wordpress menu.
- Classes. 
    - Unordered List Classes. The class names to give the wrapping `<ul></ul>` tags of the list.
    - List Item Classes. The class names to give the `<li></li>` item tags.
    - Link Classes. The class names to give the `<a></a>` link tags.

The menu is structured like so:

```html
<ul>
    <li><a href="/menu-item-page">Menu Item</a></li>
    ...
</ul>
```

###  3.3. <a name='Taxonomy.'></a>Taxonomy.

The taxonomy row allows you to select a particular taxonomy and use each sub-category and term as a tree with links to each of those items.

- Taxonomy. The taxonomy slug name. Pick from select box.
    - Posts. Specify how to get the items from the taxonomy.
        - List Posts. Show the posts, not just the categories / sub-categories.
        - List Parent Posts. Display the parent posts in the child list.
        - Post Query. URL Query string of what to pass into the `get_posts()` function. e.g.
        ```php
        meta_key=award_level&meta_type=NUMERIC&orderby=meta_value_num&order=ASC
        ```

    - Classes. 
        - Unordered List Classes. The class names to give the wrapping `<ul></ul>` tags of the list.
        - List Item Classes. The class names to give the `<li></li>` item tags.
        - Link Classes. The class names to give the `<a></a>` link tags.

    - Expand.
        - Auto Expand. Automatically open menu up to current page.

![https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/structure.png?raw=true](https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/structure.png?raw=true)

###  3.4. <a name='Wrapper.'></a>Wrapper.

- Wrapper Classes (DIV). Any class names to give the parent `<DIV>` container that wraps the menu.

![https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/wrapper.png?raw=true](https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/wrapper.png?raw=true)

###  3.5. <a name='Code.'></a>Code.

The code tab allows you to append code around any of the levels of the menu. Before or after each tag.

The structure of the menu is like so:

```php
<ul>								// Top Level unordered list open
    <li><a></a></li>				// List item open & close + Link open & close.
    <li>							// List Item open & close.
         <a></a>					// Link open & close.
         <ul>						// Unordered list open
              <li>					// List Item open
				<a>					// Link open
					Heading(count)	// Count
				</a>				// Link Close
			  </li>					// List item close
         </ul>						// Unordered list close
    </li>							// List item close
</ul>								// Top Level - Unordered list close
```

The textboxes  allow you to inject code around any of the opening or closing tags within the structure. It also includes around the (20) count number too. 

Usage of moustache `{{name}}`, `{{tax_id}}`, etc.. tags allowed in textbox to substitute for real value. This will be a `WP_Term` object and any of the fields in that can be used.

####  3.5.1. <a name='Top-levelul'></a>Top-level `<ul>`

##### Prefix Top Unordered List Open

Add code immediately before top-level unordered list open (ul)

##### Suffix Top Unordered List Open

Add code immediately after top-level unordered list open (ul)

####  3.5.2. <a name='TopLevelul'></a>Top Level `<\ul>`

##### Prefix Top Unordered List Close

Add code immediately before top-level unordered list close (/ul)

##### Suffix Top Unordered List Close

Add code immediately after top-level unordered list close (/ul)

####  3.5.3. <a name='ul'></a>`<ul>`

##### Prefix Unordered List Open

Add code immediately before unordered list open (ul)

##### Suffix Unordered List Open

Add code immediately after unordered list open (ul)

####  3.5.4. <a name='ul-1'></a>`</ul>`

##### Prefix Unordered List Close

Add code immediately before unordered list close (/ul)

##### Suffix Unordered List Close

Add code immediately after unordered list close (/ul)

####  3.5.5. <a name='li'></a>`<li>`

##### Prefix List Item Open

Add code immediately before list item open (li)

##### Suffix List Item Open

Add code immediately after list item open (li)

####  3.5.6. <a name='li-1'></a>`</li>`

##### Prefix List Item Close

Add code immediately before list item close (/li)

##### Suffix List Item Close

Add code immediately after list item close (/li)

####  3.5.7. <a name='a'></a>`<a>`

##### Prefix Link Open

Add code immediately before opening (a) tag.

##### Suffix Link Open

Add code immediately after opening (a) tag.

####  3.5.8. <a name='a-1'></a>`<\a>`

##### Prefix Link Close

Add code immediately before closing (\a) tag.

##### Suffix Link Close

Add code immediately after closing (\a) tag.

####  3.5.9. <a name='Countnumber66'></a>Count number `(66)`

##### Prefix Count

Add code immediately before (20) number count.

##### Suffix Count

Add code immediately after (20) number count.


![https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/code.png?raw=true](https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/code.png?raw=true)

###  3.6. <a name='Style.'></a>Style.

The style tab allows you to insert extra CSS inline above the menu. No need to wrap in style tags - automatically done.

Example code added on Syllabus website:

```CSS
/*
* Hide the content by default with a max-height:0
*/
.sidebar_main .tab-content {
    max-height: 0;
}

/* -------------------
* 
* IF :checked, then display all siblings by
* changing the max-height to 100vh;
* 
*/
.sidebar_main input:checked ~ .tab-content {
	max-height: 2000vh;
}

/*
 * Rotate the chevron if input checked
 */
.sidebar_main input:checked ~ label > svg#chevron {
	transform: rotate(180deg);
	fill: white;
}


/*
* Hide the checkbox 
*/
.sidebar_main input {
    position: absolute;
    opacity: 0;
    z-index: -1;
}


/*
* Hide any overflow - which is the content
*/
.sidebar_main .tab {
    width: 100%;
    overflow: hidden;
}


/*
* Make the label a block element
*/
.sidebar_main .tab-label {
    display: block;
    cursor: pointer;
}

```

![https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/style.png?raw=true](https://github.com/IORoot/wp-plugin__sidebar-creator/blob/master/files/docs/style.png?raw=true)

###  3.7. <a name='Shortcode.'></a>Shortcode.

```php
[sidebar_menu slug="test_sidebar"]
```

The slug is the one you give the menu in the `general > shortcode slug` field in the admin menu. This will then render the menu how you designed it.


##  4. <a name='Troubleshooting'></a>Troubleshooting
none.

<p align="right">(<a href="#top">back to top</a>)</p>

##  5. <a name='Contributing'></a>Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue.
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>



##  6. <a name='License'></a>License

Distributed under the MIT License.

MIT License

Copyright (c) 2022 Andy Pearson

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

<p align="right">(<a href="#top">back to top</a>)</p>



##  7. <a name='Contact'></a>Contact

Author Link: [https://github.com/IORoot](https://github.com/IORoot)

<p align="right">(<a href="#top">back to top</a>)</p>

##  8. <a name='Changelog'></a>Changelog

v1.0.0 - initial version
