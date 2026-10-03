UPDATE signupform s
SET s.loyalty_points = (
    SELECT FLOOR(COALESCE(SUM(r.total_amount), 0))
    FROM reservations r
    WHERE r.user_id = s.id
);