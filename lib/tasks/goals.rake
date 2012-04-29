task :goals => :environment do
  Goal.all.each do |goal|
    if goal.type == :article
      goal.update_attribute(:num_achieved, goal.campaign.articles.where(month: goal.campaign.month, approved: true).count) if goal.campaign
    else
      goal.update_attribute(:num_achieved, goal.campaign.articles.map{|a|a.bits.map{|b|b.clicks}}.flatten.compact.reduce(:+)) if goal.campaign
    end
  end
end
