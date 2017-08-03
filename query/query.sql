SELECT daily_date, count(1) as cnt, sum(income) as income, sum(trip_cnt) as trip_cnt, sum(trip_distance) as trip_distance FROM car_daily
where daily_date <= '2017-08-03' and daily_date >= date_add('2017-08-03',INTERVAL -10 day) and income > 0
Group By daily_date
Order By daily_date;