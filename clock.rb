require File.expand_path(File.dirname(__FILE__) + "/config/environment")
include Clockwork

handler do |job|
  Campaign.all.each do |campaign|
    campaign.update_attribute(:month, campaign.month + 1) if Time.now.day == campaign.start_day && Time.now.to_date != campaign.created_at.to_date
  end
end

every 1.day, 'campaigns.advance'
