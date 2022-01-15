set terminal png size 1500, 700
set output 'complexity/counting-same.png'
set title 'Counting Same Elements Measurements'

set xlabel 'array size'
set ylabel 'execution time'

plot "data/counting-same.dat" with lines
