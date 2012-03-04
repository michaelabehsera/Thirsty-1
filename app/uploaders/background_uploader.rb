class BackgroundUploader < CarrierWave::Uploader::Base
 include CarrierWave::RMagick

  storage :file

  def store_dir
    "#{model.class.to_s.underscore}/#{mounted_as}/#{model.id}"
  end

   def extension_white_list
     %w(jpg jpeg gif png)
   end

end
