puts 'Dropping all the collections in the database'
Mongoid.master.collections.reject { |c| c.name =~ /^system/}.each(&:drop)

Rake::Task["db:mongoid:create_indexes"].invoke
Cocktail.create(title: 'free', description: 'blog tools', price: 0)
Cocktail.create(title: '$149/month', description: '3 articles', price: 149).goals.create(num: 3, type: :article)
Cocktail.create(title: '$299/month', description: '6 articles', price: 299).goals.create(num: 6, type: :article)
Cocktail.create(title: '$499/month', description: '12 articles', price: 499).goals.create(num: 12, type: :article)
Cocktail.create(title: '$999/month', description: '21 articles', price: 999).goals.create(num: 21, type: :article)
Cocktail.create(title: '$1,999/month', description: '45 articles', price: 1999).goals.create(num: 45, type: :article)
Cocktail.create(title: '$4,999/month', description: '100 articles', price: 4999).goals.create(num: 100, type: :article)
Cocktail.create(title: '$9,999/month', description: '200 articles', price: 9999).goals.create(num: 200, type: :article)
