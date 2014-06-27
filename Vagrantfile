Vagrant.configure("2") do |config|

  ##################### APP CONFIG ######################

  db_name = 'hello_world'
  db_user = 'hello_world'
  db_port = 3306
  db_port_external = 33306
  db_host_external = '127.0.0.1'

  ##################### APP CONFIG ######################

  config.vm.box = "phusion/ubuntu-14.04-amd64"

  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 3306, host: 33306

  #config.vm.provision "shell", inline: "docker rm -f db; docker rm -f solr; docker rm -f web;"

  config.vm.provision "docker" do |d|
    d.build_image "/vagrant", args: "-t 'austinylin/test_web'"
    d.pull_images "ctlc/mysql"
    d.pull_images "quirky/solr"

    d.run "db",
      image: "ctlc/mysql",
      auto_assign_name: true,
      args: " -e MYSQL_ROOT_PASSWORD=WZrRrgi6bhYMXk9NqaBZ \
              -e MYSQL_DATABASE=#{db_name} \
              -e MYSQL_USER=#{db_user} \
              -p #{db_port}:3306"

    # docker run --name="solr" -v /vagrant/solr/data:/var/lib/solr/data quirky/solr
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
  env_php = %Q(
    <?php
      $_ENV["DB_ENV_MYSQL_DATABASE"] = "#{db_name}";
      $_ENV["DB_ENV_MYSQL_USER"] = "#{db_user}";
      $_ENV["DB_PORT_#{db_port}_TCP_ADDR"] = "#{db_host_external}";
      $_ENV["DB_PORT_#{db_port}_TCP_PORT"] = "#{db_port_external}";
    ?>
  )
  config.vm.provision "shell", inline: "echo '#{env_php}' > /vagrant/env.php"
end
