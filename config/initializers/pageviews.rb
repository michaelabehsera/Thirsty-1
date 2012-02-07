class Pageviews
  extend Garb::Model
  metrics :uniquePageviews
  dimensions :page_path
end
