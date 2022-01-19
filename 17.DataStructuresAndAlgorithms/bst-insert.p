set terminal png size 1500, 700
set output 'complexity/bst-insert-measurement.png'
set title 'BST Insert Measurement'

set xlabel 'array size'
set ylabel 'execution time'

set yrange [0:10000];
plot "data/insert-measures.dat" with lines
