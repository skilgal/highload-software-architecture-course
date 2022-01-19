set terminal png size 1500, 700
set output 'complexity/counting-random.png'
set title 'Counting Random Measurements'

set xlabel 'array size'
set ylabel 'execution time'

set yrange [0:500000];
plot 'data/counting-random.dat' with lines
