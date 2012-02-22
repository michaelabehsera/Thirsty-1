puts 'Dropping all the collections in the database'
Mongoid.master.collections.reject { |c| c.name =~ /^system/}.each(&:drop)

Rake::Task["db:mongoid:create_indexes"].invoke
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
