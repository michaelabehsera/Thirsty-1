puts 'Dropping all the collections in the database'
Mongoid.master.collections.reject { |c| c.name =~ /^system/}.each(&:drop)

Rake::Task["db:mongoid:create_indexes"].invoke
puts 'Generating cocktails'
desc = <<EOS
Free access to our platform to grow your blog and grow your revenue.

Performance-based writer management tool.
Manage all of your writers and see who performs the best every month to help you decide who you will reward more, run competitions and more.

Marketer management.
Manage all your marketers in one location, view thier ideas about SEO, social media and measure what works and what doesn't.

Blog app store.
Add bling to your blog. With one click you will be able to install new themes and add new plugins to help you grow your blog and make it more awesome.

Generate more revenue.
Once you enter our network we will be able to help you generate you additional revenue via sponsored posts on your blog. We only allow high quality relevant sponsored posts that will inform your users about interesting things in your industry and will generrate higher CPM's then the usual inefective ads.
EOS
Cocktail.create(title: 'free', description: desc, price: 0)
desc = <<EOS
Articles.
Minimum 3 articles competing for the best performance.

Reporting.
Real-time reports sent directly to your email. You don't have to run after marketers and writers anymore because now you get notifications immediately sent to you regarding when goals are completed, which writers produce the best performing articles and more.

Easy to manage.
With our Wordpress intergration approved articles are sent directly to your blog so you don't need to do any additional work.

Blog app store.
Add bling to your blog. With one click you will be able to install new themes and add new plugins to help you grow your blog and make it more awesome. 

Marketer management.
Manage all your marketers in one location, view thier ideas about SEO, social media and measure what works and what doesn't.

Marketers Support.
Participate in brainstorming sessions in real-time with our marketers. You can ask them questions about anything from SEO, social media, writing ideas, conversion strategies and more.
EOS
Cocktail.create(title: '$149/month', description: desc, price: 149).goals.create(num: 3, type: :article)
desc = <<EOS
Everything in the package above plus:

Articles.
Minimum 6 articles written by authors competing for the best performing article measured by traffic.
EOS
Cocktail.create(title: '$299/month', description: desc, price: 299).goals.create(num: 6, type: :article)
desc = <<EOS
Everything in the basic package plus:

Articles.
Minimum 12 articles written by authors competing for the best performing article measured by traffic.

Guaranteed Additional Traffic.
Guaranteed 500 unique visitors per month.
EOS
Cocktail.create(title: '$499/month', description: desc, price: 499).goals.create(num: 12, type: :article)
desc = <<EOS
Everything in the basic package plus:

Articles.
Minimum 21 articles written by authors competing for the best performing article measured by traffic.

Guaranteed Additional Traffic.
Guaranteed 1500 unique visitors per month.
EOS
Cocktail.create(title: '$999/month', description: desc, price: 999).goals.create(num: 21, type: :article)
desc = <<EOS
Everything in the basic package plus:

Articles.
Minimum 45 articles written by authors competing for the best performing article measured by traffic.

Guaranteed Additional Traffic.
Guaranteed 4000 unique visitors per month.
EOS
Cocktail.create(title: '$1,999/month', description: desc, price: 1999).goals.create(num: 45, type: :article)
desc = <<EOS
Everything in the basic package plus:

Articles.
Minimum 100 articles written by authors competing for the best performing article measured by traffic.

Guaranteed Additional Traffic.
Guaranteed 10,000 unique visitors per month.
EOS
Cocktail.create(title: '$4,999/month', description: desc, price: 4999).goals.create(num: 100, type: :article)
desc = <<EOS
Everything in the basic package plus:

Articles.
Minimum 200 articles written by authors competing for the best performing article measured by traffic.

Guaranteed Additional Traffic.
Guaranteed 25,000 unique visitors per month.
EOS
Cocktail.create(title: '$9,999/month', description: desc, price: 9999).goals.create(num: 200, type: :article)
