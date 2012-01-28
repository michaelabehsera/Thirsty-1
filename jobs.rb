require File.expand_path(File.dirname(__FILE__) + "/config/environment")
require File.expand_path(File.dirname(__FILE__) + "/lib/sitemap")
require 'juggernaut'
include Stalker

require 'pry'

job 'campaign.load' do |args|
  campaign = get_campaign(args['id'])
  urls = sitemap('http://' + args['domain'], args['domain'])
  urls.each do |url|
    html = Nokogiri::HTML open(url)
    begin
      title = html.css('title').first.children.first.text
    rescue
      title = nil
    end
    page = Page.new(url: url, title: title)
    page.campaign = campaign
    page.save
  end
  campaign.loading = false
  campaign.save
  Juggernaut.publish("/campaigns/#{campaign.id}", { sitemap: campaign.pages })
end

def get_campaign(id,tries=0)
  if tries < 5
    begin
      Campaign.find(id)
    rescue
      sleep 1
      get_campaign(id,tries + 1)
    end
  else
    Juggernaut.publish("/campaigns/#{campaign.id}", { success: false })
  end
end
