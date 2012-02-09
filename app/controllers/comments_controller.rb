class CommentsController < InheritedResources::Base
  respond_to :js

  def create
    @comment = Comment.new params[:comment]
    @comment.user = current_user
    @comment.campaign = Campaign.find(params[:id])
    @comment.create_notification if @comment.save
  end

end
