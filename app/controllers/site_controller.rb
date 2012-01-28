class SiteController < ApplicationController

  def index
    render 'campaigns' if logged_in?
  end

end
