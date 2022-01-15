set terminal png size 1500, 700
set output 'complexity/counting-diff.png'
set title 'Counting Sort Measurements'

set xlabel 'array size'
set ylabel 'execution time'

plot "data/counting-diff.dat" with lines
