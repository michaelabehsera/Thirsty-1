class ApplicationController < ActionController::Base
  protect_from_forgery

  before_filter :auth_from_cookie

  def auth_from_cookie
    begin
      auto_login(User.find(cookies[:thirsty_uid])) if cookies[:thirsty_uid].present?
    rescue
    end
  end

  expose(:notifications) {
    current_user.campaigns.where(paid: true).map {|campaign| (Campaign.where(paid: true).map{|c|c.notification} + campaign.cocktail.goals.map {|g|g.notification} + campaign.articles.map {|a|a.notification})}.flatten.compact.sort_by(&:created_at).reverse if current_user
  }
end
