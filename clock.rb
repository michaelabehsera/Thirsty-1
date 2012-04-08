require File.expand_path(File.dirname(__FILE__) + "/config/environment")
include Clockwork

handler do |job|
  case job
    when 'subscriptions.check'
      Campaign.all.each do |campaign|
        campaign.subscriptions.each do |user|
          if user.timestamp < (Time.now - 4.minutes).to_i
            campaign.subscriptions.delete user
            Juggernaut.publish campaign.uuid, { user_id: user.id, event_type: 'unsubscribe' }
          end
        end
      end
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
        goal = campaign.goals.where(type: :traffic).first
        clicks = campaign.articles.map{|a|a.bits.map{|b|b.clicks}}.flatten.compact.reduce(:+)
        goal.update_attribute(:achieved, true) if goal && clicks && clicks >= goal.num
      end
    else
      Stalker.enqueue job
  end
end

every 4.minutes, 'subscriptions.check'
every 1.hour, 'bits.update'
every 1.day, 'campaigns.advance'
every 1.day, 'reminder_email.send'
