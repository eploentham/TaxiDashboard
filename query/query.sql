SELECT daily_date, count(1) as cnt, sum(income) as income, sum(trip_cnt) as trip_cnt, sum(trip_distance) as trip_distance 
FROM car_daily
where daily_date <= '2017-08-03' and daily_date >= date_add('2017-08-03',INTERVAL -10 day) and income > 0
Group By daily_date
Order By daily_date;

SELECT hour(t_start_time), count(1) as cnt, sum(t_distance) as distance, sum(t_taxi_fare) as income 
FROM `taxi_meter` 
where t_start_time <= '2017-08-03' and t_start_time >= date_add('2017-08-03',INTERVAL -10 day) 
GROUP by hour(t_start_time)

select daily_date, count(1) as cnt from car_daily group by daily_date

select t_start_time, count(1) as cnt from taxi_meter group by date(t_start_time)