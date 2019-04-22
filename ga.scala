import org.apache.spark._
import org.apache.spark.graphx._
import scala.util.Random
object ga{
	def createTables(sqlContext:org.apache.spark.sql.SqlContext){
		sqlContext.sql("CREATE TABLE INDIVIDUO(id long,avaliacao double,datahora timestamp)")
		sqlContext.sql("CREATE TABLE GENE(individuo long,v1 long,v2 long,comp long)")

	}
	def createGraph(sc:SparkContext,dataset:String)={
		var graph = GraphLoader.edgesListFile(sc,dataset)
		graph
	}
	def initPopulation(npop:Int,neighboors:Any)={
		(0 to npop).map(
			//yields locus vector graph
			neighboors.map(v=>{
				val vert = v._1
				val neighSet = v._2
				val length = neighSet.length()
				//select a random position of neighSet
				val pos = Random.nextInt(length)
				//returns a label of vertex with your vetex random selected
				vert -> neighSet(pos)
			})

		)
		
	}
	def avaliate(pop:Seq[RDD[(Long,Long)]])={
		pop.map(ind=>{
			val graphTemp = Graph.fromEdgesTuples(ind,1)
			//components connecteds
			val cmp = graphTemp.componentsConnected(EdgeDirection.Either).vertices

			ind._1->(ind._2,cmp)

		})
		
	}

	def main(args:Array[String]){
		var datasets = Array("karate.csv","dolphins.csv")
		datasets.map(dataset=>{
			val npop = 50
			//load spark context;
			val conf = new SparkConf().setMaster("local[*]")
			val sc = new SparkContext(conf)
			val sqlContext = new org.apache.spark.sql.SqlContext(sc)
			createTables(sqlContext)
			val graph = createGraph(sc,dataset).removeSelfEdges
			//generate neighboors for each vertex.
			val neighboors = graph.collectNeighboorIds(EdgeDirection.Either).cache()
			var pop = avaliate(initPopulation(npop,neighboors))
			pop.foreach(println)

			



			sqlContext.stop()
			sc.stop()

		})
		


	}

}
