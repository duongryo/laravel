<template>
  <div class="card mx-auto" style="width:500px">
    <div class="card-header">Example Component</div>
    <div class="card-body d-flex">
      <!-- The input -->
      <div class="mr-1" id="input-1" ref="input1">1</div>
      <!--  -->
      <div class="mr-1">+</div>
      <div class="mr-1">{{ x }}</div>
      <div class="mr-1">*</div>
      <div class="mr-1">{{ y }}</div>
      <div class="mr-1">=</div>
      <div class="mr-1" id="result">{{ showResult ? result : '?' }}</div>
    </div>
    <div class="card-footer">
      <button type="button" class="btn btn-primary btn-sm" @click="showResult = true">Show result</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "ExampleComponent",
  data() {
    return {
      x: 0,
      y: 0,
      result: null,
      showResult: false,
    };
  },
  methods: {
    setInput(x, y) {
      this.x = x;
      this.y = y;
    },
    calculate() {
      //Get the input value by HTML element
      let input = Number(document.getElementById("input-1").innerHTML);

      //Calculate the result
      this.result = input + this.x / this.y;
    },
  },
  created() {
    this.setInput(3, 15);
    this.calculate();
  },
};
</script>
