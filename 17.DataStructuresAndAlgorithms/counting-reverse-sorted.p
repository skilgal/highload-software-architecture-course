
set terminal png size 1500, 700
set output 'complexity/counting-reverse-sorted.png'
set title 'Counting Reverse Sorted Measurements'

set xlabel 'array size'
set ylabel 'execution time'

set yrange [0:500000];
plot "data/counting-reverse-sorted.dat" with lines
