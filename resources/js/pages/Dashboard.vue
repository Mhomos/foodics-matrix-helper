<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">Matrix Helper</div>
            <div class="card-body">
                <form autocomplete="off" @submit.prevent="calculate" method="post">
                    <div class="form-group">
                        <label for="matrices"># Of Matrices</label>
                        <input type="number" id="matrices" class="form-control" v-model="matrices_number" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6" v-for="(matrix , index) in matrices">
                            <div class="form-group">
                                <h3>Matrix # {{ index + 1 }}</h3>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label>Rows</label>
                                        <input type="number" id="rows" v-model.number="matrix.rows" class="form-control"
                                               required @change="updateMatrix(index)">
                                    </div>
                                    <div class="col">
                                        <label>Columns</label>
                                        <input type="number" id="columns" v-model.number="matrix.columns"
                                               class="form-control"
                                               @change="updateMatrix(index)"
                                               required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <table>
                                            <tr v-for="(rows , row) in matrix.rows">
                                                <td v-for="(columns , column) in matrix.columns">
                                                    <input type="number" v-model="matrix.values[row][column]"
                                                           v-if="matrix"
                                                           class="form-control"
                                                           required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row" v-if="this.result">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Result Matrix</label>
                                <table border="1" cellpadding="5">
                                    <tr v-for="(rows , row) in this.result">
                                        <td v-for="column in rows">
                                            <input type="text" :value="column"
                                                   class="form-control"
                                                   readonly>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Calculate</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            matrices_number: 0,
            matrices: [],
            result: []
        }
    },
    methods: {
        calculate: function () {
            axios
                .post('/api/matrix/calculate', {
                    matrices: this.getMappedMatrices(),
                    operation: 'multiply',
                })
                .then(response => {
                    this.result = response.data;
                })
                .catch(error => {
                    this.has_error = true;
                });
        },
        getMappedMatrices: function () {
            return this.matrices.map(item => item.values.map(rows => rows.map(number => parseInt(number))));
        },
        updateMatrix: function (index) {
            this.resetResult();

            let matrix = this.matrices[index];
            let values = [];

            for (var i = 0; i < matrix.rows; i++) {
                values.push([]);
            }

            for (var i = 0; i < matrix.rows; i++) {
                for (var j = values[i].length; j < matrix.columns; j++) {
                    values[i].push(0);
                }
            }

            matrix.values = values;

            this.matrices[index] = matrix;
        },
        resetResult() {
            this.result = [];
        }
    },
    watch: {
        matrices_number: function (val) {
            this.resetResult();
            let matrices = [];
            for (let i = 0; i < this.matrices_number; i++) {
                matrices.push({
                    rows: 1, columns: 1, values: [
                        [0]
                    ]
                });
            }
            this.matrices = matrices;
        }
    },
}
</script>
