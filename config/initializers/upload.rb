require 'net/ftp'
require 'pry'

def upload(url, campaign)
  identifier = Time.now.to_i
  `wget #{url} -O /thirsty-tmp/#{identifier}.zip`
  `mkdir /thirsty-tmp/#{identifier}`
  `unzip /thirsty-tmp/#{identifier}.zip -d /thirsty-tmp/#{identifier}`

  Archive.read_open_filename("/thirsty-tmp/#{identifier}.zip") do |ar|
    Net::FTP.open(campaign.ftp_domain, campaign.ftp_user, campaign.ftp_pass) do |ftp|
      root_dir =
        if campaign.root_dir[-1] == '/'
          campaign.root_dir + 'wp-content/plugins/'
        else
          campaign.root_dir + '/wp-content/plugins/'
        end
      ftp.chdir root_dir
      while entry = ar.next_header
        if entry.pathname[-1] == '/'
          ftp.mkdir root_dir + entry.pathname
        else
          ftp.putbinaryfile("/thirsty-tmp/#{identifier}/" + entry.pathname, remotefile=entry.pathname)
        end
      end
    end
  end

  `rm /thirsty-tmp/#{identifier}.zip`
  `rm -rf /thirsty-tmp/#{identifier}`
end
