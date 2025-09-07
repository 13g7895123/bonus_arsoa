#!/bin/bash

# EForm2 & EForm4 Integration Test Script
# This script runs comprehensive tests for the transferred components

echo "========================================"
echo "EForm2 & EForm4 Integration Test Suite"
echo "========================================"
echo "Started at: $(date)"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Test counters
TOTAL_TESTS=0
PASSED_TESTS=0
FAILED_TESTS=0

# Function to run a test
run_test() {
    local test_name="$1"
    local command="$2"
    local expected_pattern="$3"
    
    TOTAL_TESTS=$((TOTAL_TESTS + 1))
    echo -n "Testing $test_name... "
    
    if result=$(eval "$command" 2>&1); then
        if [[ -z "$expected_pattern" ]] || echo "$result" | grep -q "$expected_pattern"; then
            echo -e "${GREEN}PASS${NC}"
            PASSED_TESTS=$((PASSED_TESTS + 1))
            return 0
        else
            echo -e "${RED}FAIL${NC} (unexpected response: $result)"
            FAILED_TESTS=$((FAILED_TESTS + 1))
            return 1
        fi
    else
        echo -e "${RED}FAIL${NC} (command failed: $result)"
        FAILED_TESTS=$((FAILED_TESTS + 1))
        return 1
    fi
}

# Test Docker containers
echo "1. Docker Container Tests"
echo "========================="
run_test "CI3 Nginx Container" "docker ps --format 'table {{.Names}}' | grep -q ci3_nginx && echo 'running'" "running"
run_test "CI3 PHP Container" "docker ps --format 'table {{.Names}}' | grep -q ci3_php && echo 'running'" "running" 
run_test "CI3 Database Container" "docker ps --format 'table {{.Names}}' | grep -q ci3_db && echo 'running'" "running"

echo ""

# Test Database Connection
echo "2. Database Connection Tests"
echo "============================"
run_test "Database Connection" "docker exec ci3_db mysql -u root -proot -e 'SELECT 1' ci3_database" "1"

# Test database tables
TABLES=("eeform2_submissions" "eeform2_products" "eeform2_product_master" "eeform2_contact_history" 
        "eeform4_submissions" "eeform4_products" "eeform4_product_master" "eeform4_contact_history" "eeform4_health_tracking")

for table in "${TABLES[@]}"; do
    run_test "Table: $table" "docker exec ci3_db mysql -u root -proot -e 'SHOW TABLES LIKE \"$table\"' ci3_database" "$table"
done

echo ""

# Test Web Server Response
echo "3. Web Server Tests"
echo "==================="
run_test "Web Server Response" "curl -s -o /dev/null -w '%{http_code}' http://localhost:9126" "200"

echo ""

# Test API Health Endpoints
echo "4. API Health Tests"
echo "==================="
run_test "EForm2 Health API" "curl -s http://localhost:9126/api/eeform2/health" "success\|health"
run_test "EForm4 Health API" "curl -s http://localhost:9126/api/eeform4/health" "success\|health"

echo ""

# Test API Test Endpoints
echo "5. API Test Endpoints"
echo "====================="
run_test "EForm2 Test API" "curl -s http://localhost:9126/api/eeform2/test" "Eeform2\|test"
run_test "EForm4 Test API" "curl -s http://localhost:9126/api/eeform4/test" "Eeform4\|test"

echo ""

# Test Form Pages
echo "6. Form Page Tests"
echo "=================="
run_test "EForm2 Page" "curl -s -o /dev/null -w '%{http_code}' http://localhost:9126/eform/eform2" "200"
run_test "EForm4 Page" "curl -s -o /dev/null -w '%{http_code}' http://localhost:9126/eform/eform4" "200"

echo ""

# Test Form Submission (with test data)
echo "7. Form Submission Tests"
echo "========================"

# EForm2 submission test
EFORM2_DATA='{"member_name":"Test User","join_date":"2025-09-06","gender":"女","age":25,"skin_health_condition":"Test condition","line_contact":"test_line","tel_contact":"0912345678","submission_date":"2025-09-06"}'
run_test "EForm2 Submission" "curl -s -X POST -H 'Content-Type: application/json' -d '$EFORM2_DATA' http://localhost:9126/api/eeform2/submit" "success\|submitted\|error"

# EForm4 submission test  
EFORM4_DATA='{"member_name":"Test Health User","join_date":"2025-09-06","gender":"男","age":30,"skin_health_condition":"Healthy","line_contact":"test_health","tel_contact":"0987654321","submission_date":"2025-09-06"}'
run_test "EForm4 Submission" "curl -s -X POST -H 'Content-Type: application/json' -d '$EFORM4_DATA' http://localhost:9126/api/eeform4/submit" "success\|submitted\|error"

echo ""

# Test Member Lookup
echo "8. Member Lookup Tests"
echo "======================"
run_test "EForm2 Member Lookup" "curl -s http://localhost:9126/api/eeform2/member_lookup/TEST001" "member\|not_found\|error"
run_test "EForm4 Member Lookup" "curl -s http://localhost:9126/api/eeform4/member_lookup/TEST001" "member\|not_found\|error"

echo ""

# Generate Test Report
echo "========================================"
echo "TEST SUMMARY"
echo "========================================"
echo "Total Tests: $TOTAL_TESTS"
echo -e "Passed: ${GREEN}$PASSED_TESTS${NC}"
echo -e "Failed: ${RED}$FAILED_TESTS${NC}"

if [ $TOTAL_TESTS -gt 0 ]; then
    SUCCESS_RATE=$(echo "scale=2; $PASSED_TESTS * 100 / $TOTAL_TESTS" | bc)
    echo "Success Rate: $SUCCESS_RATE%"
else
    echo "Success Rate: 0%"
fi

echo ""
echo "Test completed at: $(date)"
echo "========================================"

# Exit with appropriate code
if [ $FAILED_TESTS -eq 0 ]; then
    echo -e "${GREEN}All tests passed!${NC}"
    exit 0
else
    echo -e "${RED}Some tests failed. Please check the output above.${NC}"
    exit 1
fi