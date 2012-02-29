puts 'Dropping all the collections in the database'
Mongoid.master.collections.reject { |c| c.name =~ /^system/}.each(&:drop)

Rake::Task["db:mongoid:create_indexes"].invoke

puts 'Generating themes and plugins'
Theme.create(foldername: 'Amphionlite', filename: 'Amphionlite.zip', title: 'Amphionlite', description: 'desc', photo: 'http://omploader.org/vY3Y3eA')
Theme.create(foldername: 'autofocuslite', filename: 'autofocuslite-2.0.1.zip', title: 'AutoFocusLite', description: 'desc', photo: 'http://omploader.org/vY3Y3eA')
Theme.create(foldername: 'bigsquare', filename: 'big-square-1.2.zip', title: 'BigSquare', description: 'desc', photo: 'http://omploader.org/vY3Y3eA')
Theme.create(foldername: 'bonpress', filename: 'bonpress.zip', title: 'BonPress', description: 'desc', photo: 'http://omploader.org/vY3Y3eA')
Theme.create(foldername: 'gazpomag', filename: 'gazpomag.zip', title: 'Gazpomag', description: 'desc', photo: 'http://omploader.org/vY3Y3eA')
Theme.create(foldername: 'melville', filename: 'melville.zip', title: 'Melville', description: 'desc', photo: 'http://omploader.org/vY3Y3eA')
Theme.create(foldername: 'photoclick', filename: 'photoclick.zip', title: 'PhotoClick', description: 'desc', photo: 'http://omploader.org/vY3Y3eA')
Theme.create(foldername: 'shadows', filename: 'shadows.zip', title: 'Shadows', description: 'desc', photo: 'http://omploader.org/vY3Y3eA')
Theme.create(foldername: 'Shuttershot', filename: 'Shuttershot.zip', title: 'Shuttershot', description: 'desc', photo: 'http://omploader.org/vY3Y3eA')

Plugin.create(foldername: 'digg-digg', filename: 'digg-digg.5.0.2.zip', title: 'Digg-Digg', photo: 'http://omploader.org/vY3Y3eA', description: "With Digg Digg by Buffer you will get an all in one social sharing plugin displaying all social sharing buttons nicely on your blog. Make your blog look amazing, just like Mashable.")
Plugin.create(foldername: 'editorial-calendar', filename: 'editorial-calendar.1.8.6.zip', title: 'Editorial Calendar', photo: 'http://omploader.org/vY3Y3eA', description: "Did you remember to write a post for next Tuesday? What about the Tuesday after that? WordPress doesn't make it easy to see when your posts are scheduled. The editorial calendar gives you an overview of your blog and when each post will be published. You can drag and drop to move posts, edit posts right in the calendar, and manage your entire blog.")
Plugin.create(foldername: 'feedburner-circulation', filename: 'feedburner-circulation.1.2.zip', title: 'Feedburner Circulation', photo: 'http://omploader.org/vY3Y3eA', description: "Returns a database stored Feedburner Circulation Count in plain text or number format. Reduces the Feedburner API calls by only updating the circulation count hourly and serving a database cached result in between. The account you're attempting to get a \"Circulation Count\" from must have the awareness API turned on.")
Plugin.create(foldername: 'headspace2', filename: 'headspace2.zip', title: 'Headspace2', photo: 'http://omploader.org/vY3Y3eA', description: "HeadSpace2 is an all-in-one meta-data manager that allows you to fine-tune the SEO potential of your site. Visit the HeadSpace page for a video demonstration.")
Plugin.create(foldername: 'replyme', filename: 'replyme.1.0.5.zip', title: 'ReplyMe', photo: 'http://omploader.org/vY3Y3eA', description: "Send a email to author automatically while someone reply his comment. You can custom the content what you send.Note: You must enable threaded (nested) comments and deactivate the plugin like 'Wordpress Thread Comment'. ")
Plugin.create(foldername: 'revision-control', filename: 'revision-control.2.1.zip', title: 'Revision Control', photo: 'http://omploader.org/vY3Y3eA', description: "Revision Control is a plugin for WordPress which gives the user more control over the Revision functionality.")
Plugin.create(foldername: 'seo-automatic-links', filename: 'seo-automatic-links.zip', title: 'SEO Automatic Links', photo: 'http://omploader.org/vY3Y3eA', description: "SEO Smart Links provides automatic SEO benefits for your site in addition to custom keyword lists, nofollow and much more.")
Plugin.create(foldername: 'thank-me-later', filename: 'thank-me-later.2.1.zip', title: 'Thank Me Later', photo: 'http://omploader.org/vY3Y3eA', description: "Thank Me Later (TML) will automatically send an e-mail to your those who leave a comment at your blog. Use this plugin to say 'Thanks' to your visitors, and prompt them to further engage with your blog.")
Plugin.create(foldername: 'tweet-old-post', filename: 'tweet-old-post.zip', title: 'Tweet Old Post', photo: 'http://omploader.org/vY3Y3eA', description: "Tweet Old Posts randomly picks your older post based on the interval specified by you. The primary function of this plugin is to promote older blog posts by tweeting about them and getting more traffic.")
Plugin.create(foldername: 'widget-context', filename: 'widget-context.0.7.zip', title: 'Widget Context', photo: 'http://omploader.org/vY3Y3eA', description: "Widget Context allows you to specify widget visibility settings.")
Plugin.create(foldername: 'wp-dbmanager', filename: 'wp-dbmanager.zip', title: 'DB Manager', photo: 'http://omploader.org/vY3Y3eA', description: "Allows you to optimize database, repair database, backup database, restore database, delete backup database , drop/empty tables and run selected queries. Supports automatic scheduling of backing up, optimizing and repairing of database.")
Plugin.create(foldername: 'wp-pagenavi', filename: 'wp-pagenavi.2.82.zip', title: 'Page Navi', photo: 'http://omploader.org/vY3Y3eA', description: "Want to replace the old ← Older posts | Newer posts → links with some page links?")
Plugin.create(foldername: 'wp-super-cache', filename: 'wp-super-cache.1.0.zip', title: 'Super Cache', photo: 'http://omploader.org/vY3Y3eA', description: "This plugin generates static html files from your dynamic WordPress blog. After a html file is generated your webserver will serve that file instead of processing the comparatively heavier and more expensive WordPress PHP scripts.")

puts 'Generating cocktails'
desc = <<EOS
<h3>Free access to our platform to grow your blog and grow your revenue.</h3>

<h3>Performance-based writer management tool.</h3>
Manage all of your writers and see who performs the best every month to help you decide who you will reward more, run competitions and more.

<h3>Marketer management.</h3>
Manage all your marketers in one location, view thier ideas about SEO, social media and measure what works and what doesn't.

<h3>Blog app store.</h3>
Add bling to your blog. With one click you will be able to install new themes and add new plugins to help you grow your blog and make it more awesome.

<h3>Generate more revenue.</h3>
Once you enter our network we will be able to help you generate you additional revenue via sponsored posts on your blog. We only allow high quality relevant sponsored posts that will inform your users about interesting things in your industry and will generrate higher CPM's then the usual inefective ads.
EOS
Cocktail.create(title: '<h2>Free</h2>', description: desc, price: 0)
desc = <<EOS
<h3>Articles.</h3>
Minimum 3 articles competing for the best performance.

<h3>Reporting.</h3>
Real-time reports sent directly to your email. You don't have to run after marketers and writers anymore because now you get notifications immediately sent to you regarding when goals are completed, which writers produce the best performing articles and more.

<h3>Easy to manage.</h3>
With our Wordpress intergration approved articles are sent directly to your blog so you don't need to do any additional work.

<h3>Blog app store.</h3>
Add bling to your blog. With one click you will be able to install new themes and add new plugins to help you grow your blog and make it more awesome. 

<h3>Marketer management.</h3>
Manage all your marketers in one location, view thier ideas about SEO, social media and measure what works and what doesn't.

<h3>Marketers Support.</h3>
Participate in brainstorming sessions in real-time with our marketers. You can ask them questions about anything from SEO, social media, writing ideas, conversion strategies and more.
EOS
Cocktail.create(title: '<h2>$149/month</h2>', description: desc, price: 149).goals.create(num: 3, type: :article)
desc = <<EOS
<h3>Everything in the package above plus:</h3>

<h3>Articles.</h3>
Minimum 6 articles written by authors competing for the best performing article measured by traffic.
EOS
Cocktail.create(title: '<h2>$299/month</h2>', description: desc, price: 299).goals.create(num: 6, type: :article)
desc = <<EOS
<h3>Everything in the basic package plus:</h3>

<h3>Articles.</h3>
Minimum 12 articles written by authors competing for the best performing article measured by traffic.

<h3>Guaranteed Additional Traffic.</h3>
Guaranteed 500 unique visitors per month.
EOS
Cocktail.create(title: '<h2>$499/month</h2>', description: desc, price: 499).goals.create(num: 12, type: :article)
desc = <<EOS
<h3>Everything in the basic package plus:</h3>

<h3>Articles.</h3>
Minimum 21 articles written by authors competing for the best performing article measured by traffic.

<h3>Guaranteed Additional Traffic.</h3>
Guaranteed 1500 unique visitors per month.
EOS
Cocktail.create(title: '<h2>$999/month</h2>', description: desc, price: 999).goals.create(num: 21, type: :article)
desc = <<EOS
<h3>Everything in the basic package plus:</h3>

<h3>Articles.</h3>
Minimum 45 articles written by authors competing for the best performing article measured by traffic.

<h3>Guaranteed Additional Traffic.</h3>
Guaranteed 4000 unique visitors per month.
EOS
Cocktail.create(title: '<h2>$1,999/month</h2>', description: desc, price: 1999).goals.create(num: 45, type: :article)
desc = <<EOS
<h3>Everything in the basic package plus:</h3>

<h3>Articles.</h3>
Minimum 100 articles written by authors competing for the best performing article measured by traffic.

<h3>Guaranteed Additional Traffic.</h3>
Guaranteed 10,000 unique visitors per month.
EOS
Cocktail.create(title: '<h2>$4,999/month</h2>', description: desc, price: 4999).goals.create(num: 100, type: :article)
desc = <<EOS
<h3>Everything in the basic package plus:</h3>

<h3>Articles.</h3>
Minimum 200 articles written by authors competing for the best performing article measured by traffic.

<h3>Guaranteed Additional Traffic.</h3>
Guaranteed 25,000 unique visitors per month.
EOS
Cocktail.create(title: '<h2>$9,999/month</h2>', description: desc, price: 9999).goals.create(num: 200, type: :article)
