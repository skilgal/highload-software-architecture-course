FROM blackarchlinux/blackarch:latest

RUN pacman -Syu --noconfirm
RUN pacman -Sy --noconfirm \
               nano \
               htop \
               siege \
               slowhttptest \
               hping \
               synflood \
               fping

CMD ["/bin/bash"]
