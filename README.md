This application is a blog with admin panel.

### Basic packages of project:
- Laravel: 8.40
### Third-party project packages:
- Spatie/laravel-medialibrary : 9.0.0
- Cviebrock/eloquent-sluggable : 8.0

### The main entities of the project:
This blog has image slider, categories, posts, tag, static pages and widgets as basic entities.

### The project functionality description:
The main page of the blog displays a list of posts. Each post can be commented by a registered user. All posts are in categories. Widgets are little blocks with related semantics to the categories, posts and static pages and display along with them.

This project has an admin panel. In the admin panel, you can manage all blog features like:
* **Image sliders.** Image sliders are content preview images, which display on the main blog page. They rotate post preview content that belongs to posts. We can create, update and delete them. Every image slider may belong to one post and vice versa. This relationship between a post and a slider is displayed in the column of each of them

* **Categories.** Categories group posts. Each category can have many posts. The sidebar blog renders the 'Popular categories'. That popularity depends on quantity of post views. Each category can have several widgets.

* **Posts.** Posts are basic blog entities. They are displayed as a list on the main page. There are two blocks in the blog footer: the first shows popular posts based on views and the second shows recently created posts (they are cached for 24 hours). 
The sidebar has a search. The search allows us to search for posts by post titles.
Every post can be commented. Comments are added asynchronously with AJAX and after submission they displayed in reverse order sorted by created time.
Each post can have several widgets.
A post may contain multiple image along with the text its because of using CKEditor and custom image adapter for it.
Spatie media library allows you to save images to a disk after its adjustment and image information in a table.
Each post can have several tags many-to-many relationship. Each post can have many tags, and each tag can belong to many posts. Clicking on the tags below the post will take you to a list of posts related to the tag.

* **Tags.** Tags are related to posts. When creating a post, you can attach multiple tags if you want. Tags let you find posts bound by meaning.

**The admin panel:**
The main page of the administrator displays statistics about:
categories, posts, tags, sliders and pages in this program.
Here you can control the site logo using CRUD and AJAX operations to show and hide the logo and its dimensions.
