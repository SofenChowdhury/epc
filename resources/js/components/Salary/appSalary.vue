<template>
    <div>
        <div class="card-block">
            <!-- SALARY ROW 1   -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Previous Gross Salary:</label>
                    <input type="number" step="0.01" class="form-control" v-model="previous_salary" name="previous_salary" readonly/>
                </div>

                <div class="form-group col-md-3">
                    <label>Increment:</label>
                    <input type="number" class="form-control" v-model="increment" name="increment"/>
                </div>

                <div class="form-group col-md-3">
                    <label>New Gross Salary:</label>
                    <input type="number" step="0.01" class="form-control" readonly name="new_salarays" v-model="new_salarays" style="color: red"/>
                </div>

<!--                <div class="form-group col-md-3">-->
<!--                    <label>Effective Date of Increment:</label>-->
<!--                    <input type="" class="form-control datepicker" name="increment_date" v-model="increment_date" autocomplete="off"/>-->
<!--                </div>-->
                <div class="form-group col-md-3">
                    <label for="increment_date">Effective Date of Increment:</label>
                    <md-datepicker v-model="increment_date" autocomplete="off" id="increment_date" name="increment_date" class="form-control pt-1 m-0" md-immediately/>
                </div>
            </div>
        </div>

        <div class="card-block">
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Basic Salary (% of gross):</label>
                    <input type="number" class="form-control" v-model="basic_percentage" name="basic_percentage" />
                </div>

                <div class="form-group col-md-3">
                    <label>Basic Salary:</label>
                    <input type="number" step="0.01" class="form-control" v-model="basics" name="basic" />
                </div>

                <div class="form-group col-md-3">
                    <label>Medical (% of basic):</label>
                    <input type="number" class="form-control" v-model="medical_percentage" name="medical_percentage"/>
                </div>

                <div class="form-group col-md-3">
                    <label>Medical:</label>
                    <input type="number" step="0.01" class="form-control" v-model="medicals" name="medical" readonly/>
                </div>
            </div>

            <!-- SALARY ROW 2  -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Provident Fund (% of basic salary):</label>
                    <input type="number" class="form-control" v-model="provident_fund_percentage" name="provident_fund_percentage" id="provident_fund_percentage"/>
                </div>

                <div class="form-group col-md-3">
                    <label>Provident Fund:</label>
                    <input type="number" step="0.01" class="form-control" v-model="provident_funds" name="provident_funds" readonly/>
                </div>

                <div class="form-group col-md-3">
                    <label>Conveyance:</label>
                    <input type="number" class="form-control" v-model="conveyance" name="conveyance"/>
                </div>
            </div>

<!--            <div class="row">-->

<!--                <div class="form-group col-md-3">-->
<!--                    <label>Yearly Taxable Income:</label>-->
<!--                    <input type="number" class="form-control" v-model="yearly_incomes" name="yearly_income" readonly/>-->
<!--                </div>-->

<!--                <div class="form-group col-md-3">-->
<!--                    <label>Yearly Taxable Payable:</label>-->
<!--                    <input type="number" class="form-control" v-model="yearly_taxes" name="yearly_tax" readonly/>-->
<!--                </div>-->

<!--                <div class="form-group col-md-3">-->
<!--                    <label>Monthly Tax Payable:</label>-->
<!--                    <input type="number" step="0.01" class="form-control" v-model="tax_amount" name="tax_amount" readonly />-->
<!--                </div>-->

<!--                <div class="form-group col-md-3">-->
<!--                    <label>Monthly TDS (80%):</label>-->
<!--                    <input type="number" step="0.01" class="form-control" v-model="tax_payable" name="tax_payable" id="tax_payable" readonly/>-->
<!--                </div>-->
<!--            </div>-->

            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-8">
                    <div class="card-block">
                        <div class="col-sm-5 text-center">
                            <input type="submit" @click="create" class="btn btn-info" value="Save" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>{{checking}}</div>
    </div>
</template>
<script>
export default
{
    props:['employee-id'],
    data(){
        return {
            salary: {},
            basic_percentage: 0,
            basic: 0,
            provident_fund_percentage: 0,
            provident_fund: 0,
            medical_percentage: 0,
            medical: 0,
            conveyance: 0,
            yearly_income: 0,
            yearly_tax: 0,
            // tax_amount:0,
            // tax_payable:0,
            increment: 0,
            previous_salary: 0,
            new_salary: 0,
            increment_date: '',
            jubayer: 5,

        }
    },
    created() {
        axios.get(`/epc/api/employee/salary/${this.employeeId}`).then(res => (this.salary = res.data.data))
            .catch(error => (this.errors = error.response.data.errors));
    },
    methods:{
        create() {
            const jub=this.employeeId
            axios
                .post(`/epc/api/employee/salary/${this.employeeId}`,{
                    basic_percentage:this.basic_percentage,
                    basic:this.basic,
                    provident_fund_percentage:this.provident_fund_percentage,
                    provident_fund:this.provident_fund,
                    medical_percentage:this.medical_percentage,
                    medical: this.medical,
                    conveyance: this.conveyance,
                    // tax_amount:this.tax_amount,
                    // tax_payable:this.tax_payable,
                    increment: this.increment,
                    new_salary: this.new_salary,
                    increment_date: this.increment_date,


                })
                .then(function (response) {

                    window.location = '/epc/employee/' + jub + '/edit';
                }).catch(function (error) {

                window.location = '/epc/employee/' + jub + '/edit';
            });
        },
    },
    computed:{
        checking(){
            this.basic_percentage=this.salary.basic_percentage;
            this.basic=this.salary.basic;
            this.provident_fund_percentage=this.salary.provident_fund_percentage;
            this.provident_fund=this.salary.provident_fund;
            this.medical_percentage=this.salary.medical_percentage;
            this.medical=this.salary.medical;
            this.conveyance=this.salary.conveyance;
            // this.tax_amount=this.salary.tax_amount;
            // this.tax_payable=this.salary.tax_payable;
            this.previous_salary=this.salary.previous_salary;
        },
        new_salarays(){
            return this.new_salary=parseInt(this.previous_salary)+parseInt(this.increment);
        },
        basics(){
            return this.basic=(parseInt(this.new_salary)*parseInt(this.basic_percentage))/100;
        },
        provident_funds(){
            return this.provident_fund=(parseInt(this.basic)*parseInt(this.provident_fund_percentage))/100;
        },
        medicals(){
            return this.medical=(parseInt(this.basic)*parseInt(this.medical_percentage))/100;
        },
    }
}
</script>
