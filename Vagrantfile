Vagrant.configure("2") do |config|
  config.vm.box = "phusion/ubuntu-14.04-amd64"

  config.vm.network "forwarded_port", guest: 80, host: 8080
  
  config.vm.provision "shell", inline: "docker rm -f db; docker rm -f solr; docker rm -f web;"

  config.vm.provision "docker" do |d|
    d.build_image "/vagrant", args: "-t 'austinylin/test_web'"
    d.pull_images "ctlc/mysql"
    d.pull_images "quirky/solr"

    d.run "db",
      image: "ctlc/mysql",
      auto_assign_name: true,
      args: " -e MYSQL_ROOT_PASSWORD=WZrRrgi6bhYMXk9NqaBZ \
              -e MYSQL_DATABASE=hello_world \
              -e MYSQL_USER=hello_world"

    d.run "solr",
      image: "quirky/solr",
      auto_assign_name: true,
      args: "-v '/vagrant/solr/data:/var/lib/solr/data'"

    d.run "web",
      image: "austinylin/test_web",
      auto_assign_name: true,
      args: " --link db:db \
              --link solr:solr \
              -v '/vagrant:/app' \
              -p 80:80"
  end
end
