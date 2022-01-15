
set terminal png size 1500, 700
set output 'complexity/counting-sorted.png'
set title 'Counting Sort Measurements'

set xlabel 'array size'
set ylabel 'execution time'

plot "data/counting-sorted.dat" with lines
