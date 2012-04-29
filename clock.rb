require File.expand_path(File.dirname(__FILE__) + "/config/environment")
include Clockwork

handler do |job|
  case job
    when 'wordpress.check'
      Campaign.all.each do |campaign|
        if campaign.check
          campaign.update_attribute(:status, true)
        else
          campaign.update_attribute(:status, false)
        end
      end
    when 'campaigns.advance'
      Campaign.all.each do |campaign|
        if Time.now.day == campaign.start_day && Time.now.to_date != campaign.created_at.to_date
          campaign.update_attribute(:month, campaign.month + 1)
          campaign.goals.each do |goal|
            goal.update_attribute(:achieved, false)
          end
        end
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
        if goal && clicks && clicks >= goal.next_step
          goal.update_attribute(:next_step, goal.next_step + 50)
          UsersMailer.traffic_update(campaign, clicks).deliver
        end
      end
    else
      Stalker.enqueue job
  end
end

every 1.hour, 'bits.update'
every 12.hours, 'wordpress.check'
every 1.day, 'campaigns.advance'
every 1.day, 'reminder_email.send'
