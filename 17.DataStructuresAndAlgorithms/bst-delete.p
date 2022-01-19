set terminal png size 1500, 700
set output 'complexity/bst-delete-measurement.png'
set title 'BST Delete Measurement'

set xlabel 'array size'
set ylabel 'execution time'

# set yrange [200:1000];
plot "data/delete-measures.dat" with lines
