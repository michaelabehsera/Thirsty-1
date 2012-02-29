=== Thank Me Later ===
Contributors: bbosh
Plugin URI: http://blog.pipvertise.co.uk/wordpress-plugin-thank-me-later/
Tags: comment, comments, contact, email, e-mail, mail, plugin, user, users
Requires at least: 3.1
Tested up to: 3.1.3
Stable tag: 2.1

Automatically send a 'thank you' e-mail to those who comment on your blog. This plugin engages visitors by reminding them to check back for responses or new blog posts.

== Description ==

Thank Me Later (TML) will automatically send an e-mail to your those who leave a comment at your blog. Use this plugin to say 'Thanks' to your visitors, and prompt them to further engage with your blog.

TML is highly configurable. It allows you to create multiple e-mail messages and to send the message after a pre-defined amount of time, making messages appear more unique and people-friendly.

[http://blog.pipvertise.co.uk/wordpress-plugin-thank-me-later/](http://blog.pipvertise.co.uk/wordpress-plugin-thank-me-later/ "Pipvertise: Thank Me Later") 

== Changelog ==

= v2.0.0.1 =
* Fixes a bug which displays ~'Sorry: you need to be an administrator' message for all users.

= v2.0 =
* Multiple messages
* 'Better' i18n support
* nl2br() functionality, to make writing HTML messages easier.
* Syntax highlighting for PHP (limited support).
* User restrictions (ie, only send to logged in users)
* Opt out page.
* Modularised interface (and code).

= v1.5.3 =
* Uses different mode of scheduling sends, which is hopefully more reliable than WP-CRON.

= v1.5.1 =
* Fixed some minor timing issues.
* Fixed menu formatting in WP 2.7.

= v1.5 =
* Uses WP-Cron to process queue at regular intervals.
* Comes with pre-installed "templates", which allow you to quickly place titles, excerpts and URLs into your emails dynamically.
* Allows you to restrict posts by tags and categories.

== Installation ==

It's easy!

1. Upload the `thank-me-later` directory to the `/wp-content/plugins/` directory (delete any previous versions of TML).
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to 'Settings'->'Thank Me Later' to configure your message and options

== Frequently Asked Questions ==

= Why? =
Have you ever left a comment on a blog, only to forget about it and never come back? Thank Me Later is great for your blog because it reminds visitors of their comment a few days later, and prompts them to engage in further discussion and reading on your blog. It gives you the opportunity to keep alive a connection with the visitor after they have left your blog.

= Is this not a bit invasive/annoying? =
It can be, but selecting the correct options in TML will ensure it is not. For example, you can configure TML to only ever send one e-mail to each visitor, or leave a gap between sending e-mails. This will ensure you do not annoy those who actively engage with your blog.

= How do I use PHP in e-mails? =
Any text enclosed in `<?php` and `?>` (PHP code delimiters) will be treated as PHP code. You can use the variable `$comment_id` to obtain the ID of the current comment, and use this to obtain, process and output content in e-mails. You can also use some third-party plugins to insert content into e-mails.

Here are some examples of code:

1. `<?php echo "Your comment ID is $comment_id"; ?>`
1. `Your comment: "<?php $comment = get_comment($comment_id, OBJECT); echo substr($comment->comment_content, 0, 30)."..."; ?>"
1. `You can find your comment at this URL: <?php $comment = get_comment($comment_id, OBJECT); echo get_permalink($comment->comment_post_ID)."#comment-".$comment_id; ?>`

= More =
Ask lots of questions: http://blog.pipvertise.co.uk/wordpress-plugin-thank-me-later/

== Screenshots ==

1. Default admin page (Message overview)
2. Factory default e-mail
3. HTML e-mail