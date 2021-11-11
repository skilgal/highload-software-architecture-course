
# Table of Contents

1.  [System Description](#orgfa66290)
    1.  [Siege &#x2013;concurrent=10 &#x2013;time=30s](#org8c9b0fa)
    2.  [Siege -d1 -c25](#orgffe0dfa)
    3.  [[Performance Gap] Siege &#x2013;time=30s &#x2013;concurrent=30](#orga95e8e5)
    4.  [Siege &#x2013;time=30s &#x2013;concurrent=50](#orgbe5366a)
2.  [Summary](#org8c50864)
3.  [Probabistic cache model](#org66d8da6)
    1.  [[ No cache ]  siege &#x2013;concurrent=300 &#x2013;time=60s &#x2013;content-type &ldquo;application/json&rdquo; &rsquo;http://localhost:9000/movies&rsquo;](#org29ae1a5)
    2.  [[ With cache duration more than siege time ] Siege -//-](#orgc8e4d0f)
    3.  [[ With cache duration less than siege time ] Siege -//-](#orge637181)
    4.  [[ With probabilistic cache ] Siege -//-](#org82394c9)



<a id="orgfa66290"></a>

# System Description

-   During request has postgresql query
-   During request has invocation of external services
-   Each request has wrapper of DataDog agent


<a id="org8c9b0fa"></a>

## Siege &#x2013;concurrent=10 &#x2013;time=30s

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="org-left" />

<col  class="org-left" />
</colgroup>
<tbody>
<tr>
<td class="org-left">Transactions:</td>
<td class="org-left">301 hits</td>
</tr>


<tr>
<td class="org-left">Availability:</td>
<td class="org-left">100.00 %</td>
</tr>


<tr>
<td class="org-left">Elapsed time:</td>
<td class="org-left">29.85 secs</td>
</tr>


<tr>
<td class="org-left">Data transferred:</td>
<td class="org-left">0.22 MB</td>
</tr>


<tr>
<td class="org-left">Response time:</td>
<td class="org-left">0.98 secs</td>
</tr>


<tr>
<td class="org-left">Transaction rate:</td>
<td class="org-left">10.08 trans/sec</td>
</tr>


<tr>
<td class="org-left">Throughput:</td>
<td class="org-left">0.01 MB/sec</td>
</tr>


<tr>
<td class="org-left">Concurrency:</td>
<td class="org-left">9.84</td>
</tr>


<tr>
<td class="org-left">Successful transactions:</td>
<td class="org-left">301</td>
</tr>


<tr>
<td class="org-left">Failed transactions:</td>
<td class="org-left">0</td>
</tr>


<tr>
<td class="org-left">Longest transaction:</td>
<td class="org-left">1.35</td>
</tr>


<tr>
<td class="org-left">Shortest transaction:</td>
<td class="org-left">0.64</td>
</tr>
</tbody>
</table>


<a id="orgffe0dfa"></a>

## Siege -d1 -c25

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="org-left" />

<col  class="org-left" />
</colgroup>
<tbody>
<tr>
<td class="org-left">Transactions:</td>
<td class="org-left">450 hits</td>
</tr>


<tr>
<td class="org-left">Availability:</td>
<td class="org-left">100.00 %</td>
</tr>


<tr>
<td class="org-left">Elapsed time:</td>
<td class="org-left">29.97 secs</td>
</tr>


<tr>
<td class="org-left">Data transferred:</td>
<td class="org-left">0.33 MB</td>
</tr>


<tr>
<td class="org-left">Response time:</td>
<td class="org-left">1.63 secs</td>
</tr>


<tr>
<td class="org-left">Transaction rate:</td>
<td class="org-left">15.02 trans/sec</td>
</tr>


<tr>
<td class="org-left">Throughput:</td>
<td class="org-left">0.01 MB/sec</td>
</tr>


<tr>
<td class="org-left">Concurrency:</td>
<td class="org-left">24.40</td>
</tr>


<tr>
<td class="org-left">Successful transactions:</td>
<td class="org-left">450</td>
</tr>


<tr>
<td class="org-left">Failed transactions:</td>
<td class="org-left">0</td>
</tr>


<tr>
<td class="org-left">Longest transaction:</td>
<td class="org-left">2.00</td>
</tr>


<tr>
<td class="org-left">Shortest transaction:</td>
<td class="org-left">1.29</td>
</tr>
</tbody>
</table>


<a id="orga95e8e5"></a>

## [Performance Gap] Siege &#x2013;time=30s &#x2013;concurrent=30

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="org-left" />

<col  class="org-left" />
</colgroup>
<tbody>
<tr>
<td class="org-left">Transactions:</td>
<td class="org-left">423 hits</td>
</tr>


<tr>
<td class="org-left">Availability:</td>
<td class="org-left">94.84 %</td>
</tr>


<tr>
<td class="org-left">Elapsed time:</td>
<td class="org-left">29.13 secs</td>
</tr>


<tr>
<td class="org-left">Data transferred:</td>
<td class="org-left">0.46 MB</td>
</tr>


<tr>
<td class="org-left">Response time:</td>
<td class="org-left">2.30 secs</td>
</tr>


<tr>
<td class="org-left">Transaction rate:</td>
<td class="org-left">14.52 trans/sec</td>
</tr>


<tr>
<td class="org-left">Throughput:</td>
<td class="org-left">0.02 MB/sec</td>
</tr>


<tr>
<td class="org-left">Concurrency:</td>
<td class="org-left">33.40</td>
</tr>


<tr>
<td class="org-left">Successful transactions:</td>
<td class="org-left">423</td>
</tr>


<tr>
<td class="org-left">Failed transactions:</td>
<td class="org-left">23</td>
</tr>


<tr>
<td class="org-left">Longest transaction:</td>
<td class="org-left">3.63</td>
</tr>


<tr>
<td class="org-left">Shortest transaction:</td>
<td class="org-left">0.01</td>
</tr>
</tbody>
</table>


<a id="orgbe5366a"></a>

## Siege &#x2013;time=30s &#x2013;concurrent=50

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="org-left" />

<col  class="org-left" />
</colgroup>
<tbody>
<tr>
<td class="org-left">Transactions:</td>
<td class="org-left">486 hit</td>
</tr>


<tr>
<td class="org-left">Availability:</td>
<td class="org-left">92.40 %</td>
</tr>


<tr>
<td class="org-left">Elapsed time:</td>
<td class="org-left">29.67 secs</td>
</tr>


<tr>
<td class="org-left">Data transferred:</td>
<td class="org-left">0.61 MB</td>
</tr>


<tr>
<td class="org-left">Response time:</td>
<td class="org-left">2.85 secs</td>
</tr>


<tr>
<td class="org-left">Transaction rate:</td>
<td class="org-left">16.38 trans/sec</td>
</tr>


<tr>
<td class="org-left">Throughput:</td>
<td class="org-left">0.02 MB/sec</td>
</tr>


<tr>
<td class="org-left">Concurrency:</td>
<td class="org-left">46.63</td>
</tr>


<tr>
<td class="org-left">Successful transactions:</td>
<td class="org-left">486</td>
</tr>


<tr>
<td class="org-left">Failed transactions:</td>
<td class="org-left">40</td>
</tr>


<tr>
<td class="org-left">Longest transaction:</td>
<td class="org-left">3.37</td>
</tr>


<tr>
<td class="org-left">Shortest transaction:</td>
<td class="org-left">0.00</td>
</tr>
</tbody>
</table>


<a id="org8c50864"></a>

# Summary

-   System has performance gaps between 25 and 30 concurrent users
    According to the logs the root cause is in DataDog agent


<a id="org66d8da6"></a>

# Probabistic cache model

1.  Configure Playframework + MongoDB according to the [steps](https://medium.com/geekculture/rest-api-with-scala-play-framework-and-reactive-mongo-5016e57846a9)
2.  mkdir ~/data
3.  Run Scala project by
    
        sbt run
4.  Run Siege by
    
        siege -c100 -t30S --content-type "application/json" 'http://localhost:9000/movies POST { "title":"My favorite movie", "description":"My favorite movie description" }'
        siege -c50 -t60S --content-type "application/json" 'http://localhost:9000/movies GET'


<a id="org29ae1a5"></a>

## [ No cache ]  siege &#x2013;concurrent=300 &#x2013;time=60s &#x2013;content-type &ldquo;application/json&rdquo; &rsquo;http://localhost:9000/movies&rsquo;

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="org-left" />

<col  class="org-left" />
</colgroup>
<tbody>
<tr>
<td class="org-left">Transactions:</td>
<td class="org-left">26090 hits</td>
</tr>


<tr>
<td class="org-left">Availability:</td>
<td class="org-left">96.66 %</td>
</tr>


<tr>
<td class="org-left">Elapsed time:</td>
<td class="org-left">59.13 secs</td>
</tr>


<tr>
<td class="org-left">Data transferred:</td>
<td class="org-left">527.51 MB</td>
</tr>


<tr>
<td class="org-left">Response time:</td>
<td class="org-left">0.62 secs</td>
</tr>


<tr>
<td class="org-left">Transaction rate:</td>
<td class="org-left">441.23 trans/sec</td>
</tr>


<tr>
<td class="org-left">Throughput:</td>
<td class="org-left">8.92 MB/sec</td>
</tr>


<tr>
<td class="org-left">Concurrency:</td>
<td class="org-left">273.61</td>
</tr>


<tr>
<td class="org-left">Successful transactions:</td>
<td class="org-left">26090</td>
</tr>


<tr>
<td class="org-left">Failed transactions:</td>
<td class="org-left">902</td>
</tr>


<tr>
<td class="org-left">Longest transaction:</td>
<td class="org-left">14.81</td>
</tr>


<tr>
<td class="org-left">Shortest transaction:</td>
<td class="org-left">0.01</td>
</tr>
</tbody>
</table>


<a id="orgc8e4d0f"></a>

## [ With cache duration more than siege time ] Siege -//-

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="org-left" />

<col  class="org-left" />
</colgroup>
<tbody>
<tr>
<td class="org-left">Transactions:</td>
<td class="org-left">32344 hits</td>
</tr>


<tr>
<td class="org-left">Availability:</td>
<td class="org-left">97.98 %</td>
</tr>


<tr>
<td class="org-left">Elapsed time:</td>
<td class="org-left">60.04 secs</td>
</tr>


<tr>
<td class="org-left">Data transferred:</td>
<td class="org-left">653.96 MB</td>
</tr>


<tr>
<td class="org-left">Response time:</td>
<td class="org-left">0.34 secs</td>
</tr>


<tr>
<td class="org-left">Transaction rate:</td>
<td class="org-left">538.71 trans/sec</td>
</tr>


<tr>
<td class="org-left">Throughput:</td>
<td class="org-left">10.89 MB/sec</td>
</tr>


<tr>
<td class="org-left">Concurrency:</td>
<td class="org-left">180.48</td>
</tr>


<tr>
<td class="org-left">Successful transactions:</td>
<td class="org-left">32344</td>
</tr>


<tr>
<td class="org-left">Failed transactions:</td>
<td class="org-left">666</td>
</tr>


<tr>
<td class="org-left">Longest transaction:</td>
<td class="org-left">22.67</td>
</tr>


<tr>
<td class="org-left">Shortest transaction:</td>
<td class="org-left">0.00</td>
</tr>
</tbody>
</table>


<a id="orge637181"></a>

## [ With cache duration less than siege time ] Siege -//-

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="org-left" />

<col  class="org-left" />
</colgroup>
<tbody>
<tr>
<td class="org-left">Transactions:</td>
<td class="org-left">32640 hits</td>
</tr>


<tr>
<td class="org-left">Availability:</td>
<td class="org-left">98.35 %</td>
</tr>


<tr>
<td class="org-left">Elapsed time:</td>
<td class="org-left">59.34 secs</td>
</tr>


<tr>
<td class="org-left">Data transferred:</td>
<td class="org-left">659.94 MB</td>
</tr>


<tr>
<td class="org-left">Response time:</td>
<td class="org-left">0.27 secs</td>
</tr>


<tr>
<td class="org-left">Transaction rate:</td>
<td class="org-left">550.05 trans/sec</td>
</tr>


<tr>
<td class="org-left">Throughput:</td>
<td class="org-left">11.12 MB/sec</td>
</tr>


<tr>
<td class="org-left">Concurrency:</td>
<td class="org-left">148.91</td>
</tr>


<tr>
<td class="org-left">Successful transactions:</td>
<td class="org-left">32640</td>
</tr>


<tr>
<td class="org-left">Failed transactions:</td>
<td class="org-left">549</td>
</tr>


<tr>
<td class="org-left">Longest transaction:</td>
<td class="org-left">20.90</td>
</tr>


<tr>
<td class="org-left">Shortest transaction:</td>
<td class="org-left">0.00</td>
</tr>
</tbody>
</table>


<a id="org82394c9"></a>

## [ With probabilistic cache ] Siege -//-

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="org-left" />

<col  class="org-left" />
</colgroup>
<tbody>
<tr>
<td class="org-left">Transactions:</td>
<td class="org-left">30419 hits</td>
</tr>


<tr>
<td class="org-left">Availability:</td>
<td class="org-left">98.93 %</td>
</tr>


<tr>
<td class="org-left">Elapsed time:</td>
<td class="org-left">59.46 secs</td>
</tr>


<tr>
<td class="org-left">Data transferred:</td>
<td class="org-left">615.04 MB</td>
</tr>


<tr>
<td class="org-left">Response time:</td>
<td class="org-left">0.55 secs</td>
</tr>


<tr>
<td class="org-left">Transaction rate:</td>
<td class="org-left">511.59 trans/sec</td>
</tr>


<tr>
<td class="org-left">Throughput:</td>
<td class="org-left">10.34 MB/sec</td>
</tr>


<tr>
<td class="org-left">Concurrency:</td>
<td class="org-left">280.77</td>
</tr>


<tr>
<td class="org-left">Successful transactions:</td>
<td class="org-left">30419</td>
</tr>


<tr>
<td class="org-left">Failed transactions:</td>
<td class="org-left">329</td>
</tr>


<tr>
<td class="org-left">Longest transaction:</td>
<td class="org-left">26.92</td>
</tr>


<tr>
<td class="org-left">Shortest transaction:</td>
<td class="org-left">0.00</td>
</tr>
</tbody>
</table>

