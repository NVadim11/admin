FROM 670285250765.dkr.ecr.eu-central-1.amazonaws.com/theshit/php-base:latest

ADD . /home/ubuntu/theshit_php/

WORKDIR /home/ubuntu/theshit_php/

RUN rm -fr bitbucket-pipelines.yml Dockerfile .env_example .git* && \
    chown -R ubuntu:ubuntu /home/ubuntu/theshit_php/

RUN sudo -u ubuntu mkdir -p storage/app/public storage/app/public storage/debugbar storage/framework/cache storage/framework/sessions \
    storage/framework/views storage/framework/cache/data storage/logs public/uploads/files public/uploads/images/webp && \
    sudo -u ubuntu php -d memory_limit=-1 composer.phar install

EXPOSE 80

STOPSIGNAL SIGQUIT

CMD ["./entrypoint.sh"]