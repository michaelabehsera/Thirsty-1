def sitemap(url,host,links=[])
  begin
    html = Nokogiri::HTML open(url)
    html.css('a').each do |element|
      if element.attributes['href']
        link = parse_url(element.attributes['href'], host)
        unless link.nil? || links.include?(link) && !link.nil?
          links << link
          sitemap(link,host,links)
        end
      end
    end
  rescue
  end
  links.flatten.uniq.compact
end

def parse_url(url,host)
  url = URI::parse url
  if url.relative?
    if url.to_s.length > 1 && url.to_s[0] != '/'
      parse_url('http://' + url.path,host)
    else
      'http://' + host + url.path
    end
  else
    if url.host =~ /#{host}$/
      'http://' + url.hostname + url.path
    else
      nil
    end
  end
end
