require File.expand_path(File.dirname(__FILE__) + "/config/environment")
include ActionView::Helpers::TextHelper
include Stalker

job 'tool.upload' do |args|
  campaign = Campaign.find(args['cid'])
  plugin = Plugin.find(args['id'])
  begin
    upload plugin, args['creds']
    Juggernaut.publish campaign.uuid, { event_type: 'install_success' }
  rescue
    Juggernaut.publish campaign.uuid, { event_type: 'install_failure' }
  end
end

job 'theme.upload' do |args|
  campaign = Campaign.find(args['cid'])
  plugin = Theme.find(args['id'])
  begin
    upload plugin, args['creds']
    Juggernaut.publish campaign.uuid, { event_type: 'install_success', plugin: plugin.id }
  rescue
    Juggernaut.publish campaign.uuid, { event_type: 'install_failure', plugin: plugin.id }
  end
end

job 'analytics.send' do |args|
  article = Article.find args['id']
  User.where(type: :marketer).each do |marketer|
    unless marketer == article.user
      Pony.mail(
        to: marketer.email,
        from: 'mike@thirsty.com',
        subject: 'A new article has been submitted!',
        body: "A new article has been submitted to the #{article.campaign.title} campaign. Check it out in the #{link_to 'analytics tab', "http://thirsty.com/campaigns/#{article.campaign.uuid}?article=#{article.id}"}",
        headers: { 'Content-Type' => 'text/html' },
        via: :smtp,
        via_options: {
          address: 'smtp.gmail.com',
          port: '587',
          enable_starttls_auto: true,
          user_name: 'mike@thirsty.com',
          password: 'AAA123321',
          authentication: :plain,
          domain: 'thirsty.com'
        }
      )
    end
  end
end

job 'notification.send' do |args|
  notification = Notification.find args['id']
  child = notification.article || notification.comment || notification.campaign || notification.goal
  user_name = child.user.first_name + ' ' + child.user.last_name unless notification.campaign || notification.goal
  title =
    if notification.article
      'New article submission on your Thirsty campaign!'
    elsif notification.comment
      'New idea for your Thirsty campaign!'
    elsif notification.campaign
      'New Thirsty campaign!'
    elsif notification.goal
      'A goal has been reached on your Thirsty campaign!'
    end
  message =
    if notification.article
      "#{link_to user_name, "http://thirsty.com/profile/#{child.user.username}"} just submitted an article for your <a href=\"http://thirsty.com/campaigns/#{child.campaign.uuid}\">#{child.campaign.title}</a> campaign. Check it out in your #{link_to 'article submissions tab', "http://thirsty.com/campaigns/#{child.campaign.uuid}"}."
    elsif notification.comment
      "#{user_name} just suggested an idea for your #{child.campaign.title} campaign.<br/><br/>#{child.title}:<br/>#{child.message}"
    elsif notification.campaign
      "There's been a new campaign created on Thirsty! Come check it out at http://thirsty.com/campaigns/#{child.campaign.uuid}."
    elsif notification.goal
      if child.type == :article
        "A goal has been reached! You've approved #{pluralize child.num, child.type.to_s} within this last month on your <a href=\"http://thirsty.com/campaigns/#{child.campaign.uuid}\">#{child.campaign.title}</a> campaign."
      elsif child.type == :traffic
        "A goal has been reached! You've gotten #{child.num} additional unique visitors within this last month on your <a href=\"http://thirsty.com/campaigns/#{child.campaign.uuid}\">#{child.campaign.title}</a> campaign."
      end
    end
  if notification.campaign
    User.where(type: :marketer).each do |marketer|
      unless marketer == child.user
        Pony.mail(
          to: marketer.email,
          from: 'mike@thirsty.com',
          subject: title,
          body: message,
          headers: { 'Content-Type' => 'text/html' },
          via: :smtp,
          via_options: {
            address: 'smtp.gmail.com',
            port: '587',
            enable_starttls_auto: true,
            user_name: 'mike@thirsty.com',
            password: 'AAA123321',
            authentication: :plain,
            domain: 'thirsty.com'
          }
        )
      end
    end
  else
    Pony.mail(
      to: child.campaign.user.email,
      from: 'mike@thirsty.com',
      subject: title,
      body: message,
      headers: { 'Content-Type' => 'text/html' },
      via: :smtp,
      via_options: {
        address: 'smtp.gmail.com',
        port: '587',
        enable_starttls_auto: true,
        user_name: 'mike@thirsty.com',
        password: 'AAA123321',
        authentication: :plain,
        domain: 'thirsty.com'
      }
    )
  end
end
