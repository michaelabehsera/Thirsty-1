puts 'Dropping all the collections in the database'
Mongoid.master.collections.reject { |c| c.name =~ /^system/}.each(&:drop)

Rake::Task["db:mongoid:create_indexes"].invoke

