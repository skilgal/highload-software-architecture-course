FROM ubuntu:14.04

MAINTAINER Dmytro Altsyvanovych <dmytro.altsyvanovych@gmail.com>

RUN apt-get -y update

# install sshd
RUN apt-get install -y vim openssh-server

# enable login with root over ssh
RUN mkdir /var/run/sshd
RUN echo 'root:root' | chpasswd
RUN sed -i 's/PermitRootLogin without-password/PermitRootLogin yes/' /etc/ssh/sshd_config
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

# create volume
RUN mkdir -p /root/build
RUN mkdir -p /root/aprof
VOLUME /root/build

# http://packages.ubuntu.com/de/trusty/build-essential
RUN apt-get -y install build-essential

# Run additions
RUN apt-get -y install git autotools-dev automake

# http://packages.ubuntu.com/de/trusty/valgrind
RUN git clone https://github.com/ercoppa/aprof /root/aprof

WORKDIR /root/aprof/valgrind
RUN ./build.sh

ENV PATH $PATH:/root/aprof/valgrind/inst/bin
RUN export PATH=$PATH:/root/aprof/valgrind/inst/bin

# launch
CMD /usr/sbin/sshd -D
EXPOSE 22
