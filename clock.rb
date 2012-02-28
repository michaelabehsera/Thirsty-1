require File.expand_path(File.dirname(__FILE__) + "/config/environment")
include Clockwork

handler do |job|
  case job
    when 'campaigns.advance'
      Campaign.all.each do |campaign|
        campaign.update_attribute(:month, campaign.month + 1) if Time.now.day == campaign.start_day && Time.now.to_date != campaign.created_at.to_date
      end
    when 'bits.update'
      Campaign.all.each do |campaign|
        campaign.articles.where(month: campaign.month).each do |article|
          article.bits.each do |bit|
            bit.update_attribute(:clicks, BitLy.clicks(bit['hash']).user_clicks)
          end
        end
        goal = campaign.where(type: :traffic).first
        goal.update_attribute(:achieved, true) if goal && campaign.articles.map{|a|a.bits.map{|b|b.clicks}}.flatten.compact.reduce(:+) >= goal.num
      end
  end
end

every 1.day, 'campaigns.advance'
every 1.hour, 'bits.update'
