require File.expand_path(File.dirname(__FILE__) + "/config/environment")
include Stalker

job 'notification.send' do |args|
  notification = Notification.find args['id']
  child = notification.article || notification.comment || notification.campaign
  user_name = child.user.first_name + ' ' + child.user.last_name unless notification.campaign
  title =
    if notification.article
      'New article submission on your Thirsty campaign!'
    elsif notification.comment
      'New idea for your Thirsty campaign!'
    elsif notification.campaign
      'New Thirsty campaign!'
    end
  message =
    if notification.article
      "#{user_name} just submitted an article for your <a href=\"#{child.campaign.url}\">#{child.campaign.title}</a> campaign. Check it out in your article submissions tab."
    elsif notification.comment
      "#{user_name} just suggested an idea for your #{child.campaign.title} campaign.<br/><br/>#{child.title}:<br/>#{child.message}"
    elsif notification.campaign
      "There's been a new campaign created on Thirsty! Come check it out at #{child.url}."
    end
  if notification.campaign
    User.where(type: :marketer).each do |marketer|
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
